import type { Actions } from "./$types";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

import axios from "axios";

import { z } from "zod";

import { handleRequest, messages } from "$lib/functions";
import { ACCEPTED_IMAGE_TYPES, MAX_FILE_SIZE } from "$lib/constants";

const successSignup = "Panelinizi başarı ile oluşturuldu.";

const signupSchema = z.object({
  name: z.string().min(1, messages.empty("Otel Adı")),
  model: z.string().min(1, messages.empty("Araba Modeli")),
  brand: z.string().min(1, messages.empty("Araba Markası")),
  license_plate: z.string().min(1, messages.empty("Araba Plakası")),
  price: z.string().min(1, messages.empty("Araba Kiralama fiyatı")),
  discounted_price: z.string().optional(),
  description: z.string().min(1, messages.empty("Otel Açıklaması")),
});

export const actions = {
  createHotel: async ({ request, cookies }) => {
    return handleRequest(async () => {
      const formData = new FormData();

      const data = Object.fromEntries(await request.formData());

      console.log(data);

      const body = signupSchema.parse(data);

      for (const [key, value] of Object.entries(body)) {
        formData.append(key, value);
      }

      const user = JSON.parse(cookies.get("user") || "{}");

      formData.append("user_id", user.id);

      await axios.post(`${PUBLIC_BACKEND_URL}/vehicles`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
          token: "Bearer " + user.token,
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
