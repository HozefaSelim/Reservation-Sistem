import type { Actions, PageServerLoad } from "./$types";

import { z } from "zod";

import { cookieData, handleRequest, messages } from "$lib/functions";
import { Authenticate } from "$lib/functions";
import axios from "axios";

export const actions = {
  logout: async ({ cookies }) => {
    return handleRequest(async () => {
      const token = cookies.get("token");

      await axios.post(
        "http://127.0.0.1:8000/api/logout",
        {},
        {
          headers: {
            Authorization: `Bearer ${token}`, // Send token in Authorization header
          },
        }
      );

      cookies.delete("token", { path: "/" });

      return {
        title: messages.successTitle,
        message: "Başarı ile çıkış yaptınız.",
        path: "/",
      };
    });
  },
} satisfies Actions;
