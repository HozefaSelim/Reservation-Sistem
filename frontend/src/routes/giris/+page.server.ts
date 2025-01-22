import type { Actions, PageServerLoad } from "./$types";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

import { z } from "zod";

import { cookieData, handleRequest, messages } from "$lib/functions";
import { Authenticate } from "$lib/functions";
import axios from "axios";

export const load: PageServerLoad = async ({ cookies }) => {
  Authenticate(cookies, 2);
};

const successLogin = "Başarı ile giriş yapıldı.";

const loginSchema = z.object({
  email: z.string().email(messages.notValid("e-posta")),
  password: z
    .string()
    .min(8, messages.length("Şifre", "az 8"))
    .max(16, messages.length("Şifre", "fazla 16"))
    .refine(
      (password) =>
        /[a-z]/.test(password) && /[A-Z]/.test(password) && /\d/.test(password),
      {
        message: messages.describe.password,
      }
    ),
});

export const actions = {
  default: async ({ request, cookies }) => {
    return handleRequest(async () => {
      const data = Object.fromEntries(await request.formData());
      const body = loginSchema.parse(data);

      const res = await axios.post(`${PUBLIC_BACKEND_URL}/login`, body);

      cookies.set("user", JSON.stringify(res.data.data), cookieData());

      return {
        title: messages.successTitle,
        message: successLogin,
        path: "/",
      };
    });
  },
} satisfies Actions;
