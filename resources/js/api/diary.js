import { Inertia } from '@inertiajs/inertia'
export const fetchEntries = async (payload) => {
    const response = await axios.get(`/api/users/${Inertia.page.props.auth.user.id}/nutrition-diary-entries`, { params: payload });
    return response.data.data
}
