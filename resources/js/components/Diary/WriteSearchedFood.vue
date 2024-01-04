<template>
  <div class="px-4 py-3">
    <TextareaInput
      placeholder="Specify in free form what you have eaten, e.g. 1 chicken breast no skin with mashed potato 1 small portion"
    />

    <div class="mt-4 flex justify-end">
      <div>
        <PrimaryButton>Analyze</PrimaryButton>
      </div>
    </div>
  </div>
</template>

<script>
import TextareaInput from "@/components/Shareable/Input/TextareaInput";
import PrimaryButton from "@/components/Shareable/Input/PrimaryButton";
export default {
  components: { TextareaInput, PrimaryButton },
};
</script>
