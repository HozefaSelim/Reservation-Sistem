import type { Actions, PageServerLoad } from "./$types";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

import axios from "axios";

import { z } from "zod";

import { handleRequest, messages, Authenticate } from "$lib/functions";
import { ACCEPTED_IMAGE_TYPES, MAX_FILE_SIZE } from "$lib/constants";

export const load: PageServerLoad = async ({ cookies }) => {
  Authenticate(cookies, 2);
};

const successSignup = "Mailinize gelen doğrulama mesajı onaylayın.";

const signupSchema = z
  .object({
    email: z.string().email(messages.notValid("e-posta")),
    name: z.string().min(1, messages.empty("Name")),
    phone: z.string().min(11, messages.describe.phone),
    password: z
      .string()
      .min(8, messages.length("Şifre", "az 8"))
      .max(16, messages.length("Şifre", "fazla 16"))
      .refine(
        (password) =>
          /[a-z]/.test(password) &&
          /[A-Z]/.test(password) &&
          /\d/.test(password),
        {
          message: messages.describe.password,
        }
      ),
    confirmPassword: z.string(),
    image: z
      .any()
      .refine((file) => file instanceof File, messages.describe.image.format)
      .refine(
        (file) => file.size <= MAX_FILE_SIZE,
        messages.describe.image.size
      )
      .refine(
        (file) => ACCEPTED_IMAGE_TYPES.includes(file.type),
        messages.describe.image.type
      ),
  })
  .refine(({ password, confirmPassword }) => password === confirmPassword, {
    path: ["confirmPassword"],
    message: messages.compatible("Şifreler"),
  });

export const actions = {
  createAccount: async ({ request }) => {
    return handleRequest(async () => {
      const formData = new FormData();

      const data = Object.fromEntries(await request.formData());
      const body = signupSchema.parse(data);

      for (const [key, value] of Object.entries(body)) {
        formData.append(key, value);
      }
      formData.append("role_id", "5");

      await axios.post(`${PUBLIC_BACKEND_URL}/register`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });

      return {
        title: messages.successTitle,
        message: successSignup,
        path: "/",
      };
    });
  },
} satisfies Actions;
