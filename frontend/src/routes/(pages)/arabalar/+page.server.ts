import type { Actions, PageServerLoad } from "./$types";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

import { handleRequest } from "$lib/functions";

import axios from "axios";

export const load: PageServerLoad = async () => {
  const getCars = async () => {
    try {
      const req = await axios.get(`${PUBLIC_BACKEND_URL}/vehicles`);

      return req.data.data;
    } catch (e) {
      return [];
    }
  };

  const getOptions = async () => {
    try {
      const req = await axios.get(
        `${PUBLIC_BACKEND_URL}/vehicles-brands-models`
      );

      return req.data.data;
    } catch (e) {
      return [];
    }
  };

  return { cars: await getCars(), options: await getOptions() };
};

export const actions = {
  filter: async ({ request }) => {
    return handleRequest(async () => {
      const { model, brand, price_min, price_max, name, location, rating } =
        Object.fromEntries(await request.formData());

      const url =
        `http://127.0.0.1:8000/api/vehicles_search?rating=${rating}&name=${name}` +
        (model ? `&model=${model}` : "") +
        (brand ? `&brand=${brand}` : "") +
        (price_min ? `&price_min=${price_min}` : "") +
        (price_max ? `&price_max=${price_max}` : "");

      const res = await axios.get(url);

      return res.data.data;
    });
  },
} satisfies Actions;
