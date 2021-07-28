<template>
    <TransitionRoot
        as="template"
        :show="open"
    >
        <Dialog
            as="div"
            static
            class="fixed z-10 inset-0 overflow-y-auto"
            @close="close"
            :open="open"
        >
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 sm:block sm:p-0">
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span
                    class="hidden sm:inline-block sm:align-middle sm:h-screen"
                    aria-hidden="true"
                >&#8203;</span>
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div class="inline-block align-bottom w-full bg-white text-left overflow-hidden shadow-xl transform transition-all border-8 border-b-cyan-900 border-cyan-700 border-t-cyan-500 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="px-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 sm:mt-0 sm:ml-4 sm:text-left">
                                    <DialogTitle
                                        as="h3"
                                        class="text-lg leading-6 font-medium text-gray-900"
                                    >
                                        Bookmark Your Entry
                                    </DialogTitle>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Please specify below how many grams you ate. We will create a bookmark from your entry so you can later pull it in easily.
                                        </p>
                                        <div class="mt-4 space-y-2">
                                            <div>
                                                <TextInput
                                                    v-model="form.name"
                                                    label="Bookmark name"
                                                    placeholder="Potato"
                                                    :error="form.errors.name"
                                                />
                                            </div>
                                            <TextInput
                                                type="tel"
                                                class="font-num"
                                                v-model="form.weight"
                                                placeholder="100"
                                                :error="form.errors.weight"
                                            >
                                                <template #trailing-addon>g.</template>
                                            </TextInput>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <PrimaryButton
                                @click.prevent="submit"
                                class="!py-2 !text-base !normal-case !tracking-normal !font-num"
                            >Save</PrimaryButton>
                            <div class="text-center w-full">
                                <a
                                    href="#"
                                    @click.prevent="close"
                                    class="inline-block mt-3 text-center text-gray-500 leading-none border-b pb-px border-gray-400"
                                >Cancel</a>
                            </div>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationIcon } from '@heroicons/vue/outline'
import PrimaryButton from '@/components/Shareable/Input/PrimaryButton'
import SecondaryButton from '@/components/Shareable/Input/SecondaryButton'
import TextInput from '@/components/Shareable/Input/TextInput'
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
export default {
    props: { open: Boolean, entry: Object },
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationIcon,
        PrimaryButton,
        SecondaryButton,
        TextInput,
    },
    setup(props, context) {
        const close = () => context.emit('close')
        const form = useForm({
            weight: null,
            name: props.entry.dishName,
        })
        const submit = () => {
            form.post(`/bookmarked-nutrition-diary-entries/${props.entry.id}`, {
                preserveScroll: true,
                onSuccess: () => close()
            })
        }
        return {
            close,
            form,
            submit
        }
    },
}

</script>
