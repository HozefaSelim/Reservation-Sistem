import { Authenticate } from "@/lib/functions";
import type { PageServerLoad } from "./$types";

export const load: PageServerLoad = async ({ cookies }) => {
  Authenticate(cookies, 1);
};
