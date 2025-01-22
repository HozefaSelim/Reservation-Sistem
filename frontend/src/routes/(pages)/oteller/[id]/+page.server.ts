import type { PageServerLoad } from "./$types";

import { Authenticate } from "$lib/functions";
import axios from "axios";
import { redirect } from "@sveltejs/kit";

export const load: PageServerLoad = async ({ cookies, params }) => {
  const getHotel = async () => {
    try {
      const req = await axios.get(
        `http://127.0.0.1:8000/api/hotels/${params.id}`
      );

      return req.data.data;
    } catch (e) {
      return redirect(302, "/hotels");
    }
  };

  return { hotel: await getHotel() };
};
