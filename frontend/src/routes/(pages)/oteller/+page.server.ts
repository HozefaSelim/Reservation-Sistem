import type { Actions, PageServerLoad } from "./$types";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

import { handleRequest } from "$lib/functions";

import axios from "axios";

export const load: PageServerLoad = async () => {
  const getHotels = async () => {
    try {
      const req = await axios.get(`${PUBLIC_BACKEND_URL}/hotels`);

      return req.data.data;
    } catch (e) {
      return [];
    }
  };

  return { hotels: await getHotels() };
};

export const actions = {
  filter: async ({ request }) => {
    return handleRequest(async () => {
      const { name, location, rating } = Object.fromEntries(
        await request.formData()
      );

      const url =
        `http://127.0.0.1:8000/api/hotels_search?rating=${rating}&name=${name}` +
        (location ? `&location=${location}` : "");

      const res = await axios.get(url);

      return res.data.data;
    });
  },
} satisfies Actions;
