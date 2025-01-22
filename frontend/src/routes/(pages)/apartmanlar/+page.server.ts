import type { Actions, PageServerLoad } from "./$types";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

import { handleRequest } from "$lib/functions";

import axios from "axios";

export const load: PageServerLoad = async () => {
  const getAparts = async () => {
    try {
      const req = await axios.get(`${PUBLIC_BACKEND_URL}/apartments`);

      return req.data.data;
    } catch (e) {
      return [];
    }
  };

  return { aparts: await getAparts() };
};

export const actions = {
  filter: async ({ request }) => {
    return handleRequest(async () => {
      const { price_min, price_max, name, location, rating, capacity } =
        Object.fromEntries(await request.formData());

      const url =
        `http://127.0.0.1:8000/api/apartments_search?rating=${rating}` +
        (name ? `&name=${name}` : "") +
        (location ? `&location=${location}` : "") +
        (price_min ? `&price_min=${price_min}` : "") +
        (capacity ? `&capacity=${capacity}` : "") +
        (price_max ? `&price_max=${price_max}` : "");

      console.log(url);

      const res = await axios.get(url);

      return res.data.data;
    });
  },
} satisfies Actions;
