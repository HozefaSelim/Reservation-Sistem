import { Authenticate } from "@/lib/functions";
import type { PageServerLoad } from "./$types";
import { redirect } from "@sveltejs/kit";
import axios from "axios";

import { PUBLIC_BACKEND_URL } from "$env/static/public";

export const load: PageServerLoad = async ({ params, cookies }) => {
  const getRes = async () => {
    try {
      const user = JSON.parse(cookies.get("user") || "{}");

      const res = await axios.get(
        `${PUBLIC_BACKEND_URL}/my-reservations/${params.id}`,
        { headers: { Authorization: "Bearer " + user.token } }
      );

      return res.data.data;
    } catch {
      return redirect(302, "/");
    }
  };

  return { res: await getRes() };
};
