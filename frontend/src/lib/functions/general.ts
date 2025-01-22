import { goto } from "$app/navigation";
import {
  fail,
  type ActionResult,
  type ActionFailure,
  isRedirect,
  redirect,
  type Cookies,
} from "@sveltejs/kit";

import { z } from "zod";
import { toasts } from "svelte-toasts";
import moment from "moment";
import { AxiosError } from "axios";

const addToast = (
  title: any = "Başlık",
  description: any = "Açıklama",
  type: "error" | "success" = "success"
) => {
  toasts.add({
    title,
    description,
    type,
    duration: 5000,
    showProgress: true,
    theme: "light",
  });
};

const formHandler = (result: ActionResult) => {
  const type = result.type;

  if (type === "success" || type === "failure") {
    const title = result.data?.title;
    const message = result.data?.message;
    const path = result.data?.path;
    const toastType = type === "failure" ? "error" : "success";
    addToast(title, message, toastType);

    if (path) {
      goto(path);
    }
  }

  if (type === "redirect") {
    goto(result.location);
  }
};

const cookieData = (expiresIn: number = 60 * 60 * 24 * 7) => {
  return {
    path: "/",
    httpOnly: true,
    sameSite: "strict" as "strict",
    secure: process.env.NODE_ENV === "production",
    maxAge: expiresIn,
  };
};

type ErrorResponse = ActionFailure<{ title: string; message: string }>;

async function handleRequest<T>(
  callback: () => Promise<T>
): Promise<T | ErrorResponse> {
  try {
    return await callback();
  } catch (e) {
    if (e instanceof AxiosError) {
      return fail(500, {
        title: "Backend Error",
        message: e.response?.data.message,
      });
    }

    if (e instanceof z.ZodError) {
      return fail(422, {
        title: "Doğrulama hatası",
        message: e.errors[0]?.message,
      });
    }
    if (e instanceof Error) {
      return fail(400, { title: messages.errorTitle, message: e.message });
    }
    if (isRedirect(e)) {
      return redirect(302, e.location);
    }

    return fail(400, {
      title: "Beklenmeyen hata",
      message: "Hatayı çözmeye çalışıyoruz.",
    });
  }
}

function getColorFromString(name: string | undefined) {
  if (!name) {
    return "000000";
  }

  let hash = 0;
  for (let i = 0; i < name.length; i++) {
    hash = name.charCodeAt(i) + ((hash << 5) - hash);
  }

  // Convert hash to a 6-digit hexadecimal color
  const color =
    ((hash >> 24) & 0xff).toString(16).padStart(2, "0") +
    ((hash >> 16) & 0xff).toString(16).padStart(2, "0") +
    ((hash >> 8) & 0xff).toString(16).padStart(2, "0");

  return color;
}

function generateUserAvatar(username: string | undefined) {
  if (!username) {
    return "xx";
  }

  return username
    ?.split(" ")
    .map((word) => word[0])
    .join("")
    .slice(0, 2);
}

const debounce = <T extends (...args: any[]) => void>(
  callback: T,
  wait: number = 500
): ((...args: Parameters<T>) => void) => {
  let timeout: ReturnType<typeof setTimeout>;

  return (...args: Parameters<T>) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => callback(...args), wait);
  };
};

const truncate = (text: string, minLength = 10) => {
  return text.length > minLength ? text.slice(0, minLength) + "..." : text;
};

function randomKeyGenerator() {
  let str = "",
    i = 0;
  while (i++ < 64) {
    let r = (Math.random() * 62) << 0;
    str += String.fromCharCode((r += r > 9 ? (r < 36 ? 55 : 61) : 48));
  }
  return str;
}

const messages = {
  empty: (name: string) => `${name} boş bırakılamaz`,
  notValid: (name: string) => `Geçersiz ${name}`,
  choose: (name: string) => `${name} seçmelisiniz`,
  oneOf: (name1: string, name2: string) =>
    `${name1} veya ${name2} alanlarından en az biri gereklidir.`,
  length: (name: string, length: string) =>
    `${name} en ${length} karakter olmalıdır`,
  isNumber: (name: string) => `${name} yalnızca rakamlardan oluşmalıdır`,
  compatible: (name: string) => `${name} eşleşmelidir`,
  errorTitle: "Hata",
  successTitle: "Başarı",
  describe: {
    phone: " Telefon numaranızın uzunluğu 11 olmalıdır.",
    password:
      "Şifre en az bir küçük harf, bir büyük harf ve bir sayı içermelidir",
    image: {
      format: "Dosya formatında bir resim yüklemelisiniz.",
      size: `Dosya boyutu 5MB'dan fazla olamaz.`,
      type: "Geçerli bir resim formatı yükleyin (JPEG, JPG, PNG).",
    },
  },
};

const submitForm = (form: HTMLFormElement) => form.requestSubmit();

const calcTotal = (
  price: number,
  rate: number | undefined,
  total: number | undefined
) => (price * (rate ?? 0)) / 100 + (total ?? 0);

function formatDate(date: Date, type = "1") {
  let curDate = new Date(date);
  let dt;
  if (type == "1") {
    dt = moment(curDate).format("DD.MM.YYYY");
  } else if (type == "2") {
    dt = moment(curDate).format("YYYY-MM-DD HH:mm");
  } else if (type == "3") {
    dt = moment(curDate).format("YYYY-MM-DD  HH:mm:ss.000");
  } else if (type == "4") {
    dt = moment(curDate).format("YYYY-MM-DD");
  } else if (type == "5") {
    dt = moment(curDate).format("HH:mm");
  }
  return dt;
}

export const handleUnauthenticated = (cookies: Cookies) => {
  cookies.delete("user", cookieData());
  return redirect(302, "/");
};

function Authenticate(cookies: Cookies, type = 1) {
  if (type === 1) {
    if (!cookies.get("user")) {
      handleUnauthenticated(cookies);
      redirect(302, "/giris");
    }
  }

  if (type === 2) {
    if (cookies.get("user")) {
      redirect(302, "/");
    }
  }
}

export {
  formHandler,
  cookieData,
  addToast,
  handleRequest,
  getColorFromString,
  generateUserAvatar,
  debounce,
  randomKeyGenerator,
  truncate,
  messages,
  submitForm,
  calcTotal,
  formatDate,
  Authenticate,
};
