import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";

export const fetchEntries = async (payload) => {
  const response = await axios.get(
    `/api/users/${usePage().props.auth.user.id}/nutrition-diary-entries`,
    { params: payload },
  );
  return response.data.data;
};
