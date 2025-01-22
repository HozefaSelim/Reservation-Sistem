import { handleRequest, messages } from "@/lib/functions";
import type { Actions } from "./$types";
import axios from "axios";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

export const actions = {
  createRoom: async ({ request, cookies }) => {
    return handleRequest(async () => {
      console.log(1);
      const formData = new FormData();

      const data = Object.fromEntries(await request.formData());

      for (const [key, value] of Object.entries(data)) {
        formData.append(key, value);
      }

      const user = JSON.parse(cookies.get("user") || "{}");

      formData.append("user_id", user.id);
      formData.append("count", "50");

      const res = await axios.post(`${PUBLIC_BACKEND_URL}/rooms`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
          Authorization: "Bearer " + user.token,
        },
      });

      console.log(res.data.data);

      return {
        title: messages.successTitle,
        message: "Odayı başarı ile oluşturdunuz.",
        path: "/panel/odalar",
      };
    });
  },
} satisfies Actions;
