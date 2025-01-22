import type { PageServerLoad } from "./$types";

import { messages, Authenticate } from "$lib/functions";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

import axios from "axios";

const createdAccount = "Hesabınız başarı ile oluşturuldu";
const routing = "5 saniye sonra panele yönlendirileceksiniz";
const unexpected = "Beklenmeyen hata oluştu.";
const solving = "Hatayı çözmeye çalışıyoruz.";

export const load: PageServerLoad = async ({ params, cookies }) => {
  Authenticate(cookies, 2);

  try {
    await axios.post(`${PUBLIC_BACKEND_URL}/email/verify/${params.token}`);

    return { status: 200, title: createdAccount, message: routing };
  } catch (e) {
    if (e instanceof Error)
      return { status: 400, title: messages.errorTitle, message: e.message };

    return { status: 400, title: unexpected, message: solving };
  }
};
