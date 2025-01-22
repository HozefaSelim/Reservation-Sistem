import axios from "axios";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

import type { Actions, PageServerLoad } from "./$types";
import { handleRequest, messages } from "@/lib/functions";

export const load: PageServerLoad = async ({ cookies }) => {
  const getRooms = async () => {
    try {
      const user = JSON.parse(cookies.get("user") || "{}");

      const req = await axios.get(
        `${PUBLIC_BACKEND_URL}/getRoomsOfHotel/${user.id}`
      );

      return req.data.data;
    } catch (e) {
      return [];
    }
  };

  return { rooms: await getRooms() };
};

export const actions = {
  filter: async ({ request }) => {
    return handleRequest(async () => {
      const { name } = Object.fromEntries(await request.formData());

      const url = `http://127.0.0.1:8000/api/hotels_search?name=${name}`;

      const res = await axios.get(url);

      return res.data.data;
    });
  },
  deleteRoom: async ({ request }) => {
    return handleRequest(async () => {
      const { id } = Object.fromEntries(await request.formData());

      const url = `http://127.0.0.1:8000/api/rooms/${id}`;

      await axios.delete(url);

      return {
        title: messages.successTitle,
        message: "Odayı başarı ile silindi",
      };
    });
  },
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
