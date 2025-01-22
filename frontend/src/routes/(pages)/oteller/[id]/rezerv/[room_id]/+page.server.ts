import { redirect } from "@sveltejs/kit";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

import type { Actions, PageServerLoad } from "./$types";
import axios from "axios";
import { handleRequest, messages } from "@/lib/functions";

export const load: PageServerLoad = async ({ url, params }) => {
  const getRoom = async () => {
    try {
      const res = await axios.get(
        `${PUBLIC_BACKEND_URL}/rooms/${params.room_id}`
      );

      return res.data.data;
    } catch {
      return redirect(302, "/");
    }
  };

  return { room: await getRoom() };
};

export const actions = {
  createRes: async ({ request, cookies, params }) => {
    return handleRequest(async () => {
      const { start_date, end_date } = Object.fromEntries(
        await request.formData()
      );

      const user = JSON.parse(cookies.get("user") || "{}");

      const res = await axios.post(
        "http://127.0.0.1:8000/api/reservations",
        {
          start_date,
          end_date,
          reservation_type: "room",
          reservation_item_id: params.room_id,
          user_id: user.id,
        },
        { headers: { Authorization: "Bearer " + user.token } }
      );

      return {
        title: messages.successTitle,
        message: "Rezervasyon başarı ile yapılmıştır.",
      };
    });
  },
} satisfies Actions;
