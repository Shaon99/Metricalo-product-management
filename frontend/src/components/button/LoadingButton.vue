<template>
  <button
    @click="handleClick"
    :type="buttonType"
    :class="`${buttonClasses}`"
    :disabled="isButtonLoading"
  >
    <span v-if="Icon" class="mr-2">
      <img
        :src="Icon"
        class="inline w-5 h-5 mr-3"
        alt="icon"
      />
    </span>
    <span v-if="!isButtonLoading">{{ buttonText }}</span>
    <span v-else>
      <img
        :src="Loading"
        class="inline w-4 h-4 mr-3 animate-spin"
        alt="loading"
      />
      {{ loadingText }}
    </span>
  </button>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";
import { Loading } from "../../assets";

const props = defineProps({
  isButtonLoading: {
    type: Boolean,
    required: true,
  },
  buttonText: {
    type: String,
    default: "button",
  },
  loadingText: {
    type: String,
    default: "Please wait...",
  },
  buttonClasses: {
    type: String,
    default:
      "px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-xl hover:bg-blue-700 focus:outline-none",
  },
  buttonType: {
    type: String,
    default: "submit",
  },
  Icon: {
    type: [Object, Function],
    default: null,
  },
});

const emit = defineEmits(["click"]);

const handleClick = () => {
  if (emit) {
    emit("click");
  }
};
</script>
