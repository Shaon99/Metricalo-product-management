<template>
  <div className="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50">
    <div className="relative w-full max-w-2xl mx-auto my-6 h-auto max-h-screen">
      <div className="relative rounded-lg bg-white shadow-lg">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div
            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"
          >
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
              Add Customer
            </h3>
            <button
              @click="close"
              type="button"
              class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
              data-modal-hide="authentication-modal"
            >
              <svg
                class="w-3 h-3"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 14"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-4 md:p-5">
            <form
              class="space-y-4"
              @submit.prevent="customerStore.storeCustomer(form)"
            >
              <div class="mb-4 grid grid-cols-2 gap-4">
                <div class="col-span-1">
                  <label
                    for="first_name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >First Name</label
                  >
                  <input
                    name="first_name"
                    type="string"
                    v-model="form.first_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Enter customer first name"
                    required=""
                  />
                  <p
                    v-if="customerStore.formErrors.first_name"
                    class="text-xs text-red-500 flex items-center mt-2"
                  >
                    <img
                      :src="Check"
                      class="mr-2 w-[14px] h-[14px]"
                      alt="check"
                    />
                    <span>{{ customerStore.formErrors.first_name[0] }}</span>
                  </p>
                </div>

                <div class="col-span-1">
                  <label
                    for="last_name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Last Name</label
                  >
                  <input
                    name="first_name"
                    type="string"
                    v-model="form.last_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Enter customer last name"
                  />
                  <p
                    v-if="customerStore.formErrors.last_name"
                    class="text-xs text-red-500 flex items-center mt-2"
                  >
                    <img
                      :src="Check"
                      class="mr-2 w-[14px] h-[14px]"
                      alt="check"
                    />
                    <span>{{ customerStore.formErrors.last_name[0] }}</span>
                  </p>
                </div>
                <div class="col-span-1">
                  <label
                    for="email"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Email</label
                  >
                  <input
                    name="email"
                    type="text"
                    v-model="form.email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Enter email address"
                    required=""
                  />
                  <p
                    v-if="customerStore.formErrors.email"
                    class="text-xs text-red-500 flex items-center mt-2"
                  >
                    <img
                      :src="Check"
                      class="mr-2 w-[14px] h-[14px]"
                      alt="check"
                    />
                    <span>{{ customerStore.formErrors.email[0] }}</span>
                  </p>
                </div>
                <div class="col-span-1">
                  <label
                    for="phone"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Phone</label
                  >
                  <input
                    name="price"
                    type="text"
                    v-model="form.phone"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Enter phone number"
                    required=""
                  />
                  <p
                    v-if="customerStore.formErrors.phone"
                    class="text-xs text-red-500 flex items-center mt-2"
                  >
                    <img
                      :src="Check"
                      class="mr-2 w-[14px] h-[14px]"
                      alt="check"
                    />
                    <span>{{ customerStore.formErrors.phone[0] }}</span>
                  </p>
                </div>

                <div class="col-span-1">
                  <label
                    for="address"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Address</label
                  >
                  <textarea
                    v-model="form.address"
                    rows="2"
                    name="address"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Enter your text here..."
                    required=""
                  ></textarea>
                  <p
                    v-if="customerStore.formErrors.address"
                    class="text-xs text-red-500 flex items-center mt-2"
                  >
                    <img
                      :src="Check"
                      class="mr-2 w-[14px] h-[14px]"
                      alt="check"
                    />
                    <span>{{ customerStore.formErrors.address[0] }}</span>
                  </p>
                </div>
              </div>
              <div class="flex justify-end">
                <LoadingButton
                  :isButtonLoading="customerStore.isButtonLoading"
                  buttonText="Add Customer"
                  buttonType="submit"
                  buttonClasses="w-1/4 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-xl hover:bg-blue-700 focus:outline-none"
                />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { defineEmits, ref, defineExpose } from "vue";
import LoadingButton from "../button/LoadingButton.vue";
import { useCustomerStore } from "../../stores/customerStore";
import { Check } from "../../assets";

const customerStore = useCustomerStore();

const props = defineProps({
  modelValue: {
    type: Boolean,
    required: true,
  },
});

const form = ref({
  first_name: "",
  last_name: "",
  email: "",
  phone: "",
  address: "",
});

const resetForm = () => {
  form.value = {
    first_name: "",
    last_name: "",
    email: "",
    phone: "",
    address: "",
  };
};

const emits = defineEmits(["update:modelValue"]);

const close = () => {
  emits("update:modelValue", false);
};

defineExpose({ resetForm });
</script>
