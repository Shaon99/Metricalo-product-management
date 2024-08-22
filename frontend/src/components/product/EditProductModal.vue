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
              Edit Product: {{ form.productName ?? "N/A" }}
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
              @submit.prevent="productStore.updateProduct(form)"
            >
              <div class="mb-4 grid grid-cols-2 gap-4">
                <div class="col-span-1">
                  <label
                    for="name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Title</label
                  >
                  <input
                    name="name"
                    type="string"
                    v-model="form.productName"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Enter product title"
                  />
                  <p
                    v-if="productStore.formErrors.name"
                    class="text-xs text-red-500 flex items-center mt-2"
                  >
                    <img
                      :src="Check"
                      class="mr-2 w-[14px] h-[14px]"
                      alt="check"
                    />
                    <span>{{ productStore.formErrors.name[0] }}</span>
                  </p>
                </div>

                <div class="col-span-1">
                  <label
                    for="price"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Price</label
                  >
                  <input
                    name="price"
                    type="number"
                    v-model="form.productPrice"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Enter product price"
                  />
                  <p
                    v-if="productStore.formErrors.price"
                    class="text-xs text-red-500 flex items-center mt-2"
                  >
                    <img
                      :src="Check"
                      class="mr-2 w-[14px] h-[14px]"
                      alt="check"
                    />
                    <span>{{ productStore.formErrors.price[0] }}</span>
                  </p>
                </div>

                <div class="col-span-2">
                  <label
                    for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Description</label
                  >
                  <textarea
                    v-model="form.productDescription"
                    rows="3"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Enter your text here..."
                  ></textarea>
                  <p
                    v-if="productStore.formErrors.description"
                    class="text-xs text-red-500 flex items-center mt-2"
                  >
                    <img
                      :src="Check"
                      class="mr-2 w-[14px] h-[14px]"
                      alt="check"
                    />
                    <span>{{ productStore.formErrors.description[0] }}</span>
                  </p>
                </div>
                <div class="col-span-1">
                    <label
                      for="file"
                      class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >
                      Image
                    </label>
                    <input
                      name="file"
                      type="file"
                      id="picture"
                      @change="handleFileChange"
                      accept="image/*"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    />
                    <p
                      v-if="productStore.formErrors.file"
                      class="text-xs text-red-500 flex items-center mt-2"
                    >
                      <img
                        :src="Check"
                        class="mr-2 w-[14px] h-[14px]"
                        alt="check"
                      />
                      <span>{{ productStore.formErrors.file[0] }}</span>
                    </p>
                  </div>
                  <div class="col-span-1">
                    <img
                      v-if="previewImage"
                      :src="previewImage"
                      class="h-30 w-40 object-cover mx-auto rounded-md"
                      alt="Picture"
                    />
                    <img
                      v-else
                      :src="form.productImage"
                      class="h-30 w-40 object-cover mx-auto rounded-md"
                      alt=""
                    />
                  </div>
              </div>
              <div class="flex justify-end">
                <LoadingButton
                  :isButtonLoading="productStore.isButtonLoading"
                  buttonText="Update Product"
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
import { defineEmits, ref, watch } from "vue";
import LoadingButton from "../button/LoadingButton.vue";
import { useProductStore } from "../../stores/productStore";
import { Check } from "../../assets";

const productStore = useProductStore();

const props = defineProps({
  modelValue: {
    type: Boolean,
    required: true,
  },
  product: {
    type: Object,
    required: true,
  },
});
const previewImage = ref("");
const handleFileChange = (event) => {
  const file = event.target.files[0];
  form.value.productImage = file;

  if (file) {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = (e) => {
      previewImage.value = e.target.result;
    };
  }
};
const form = ref({
  productName: props.product.name,
  productPrice: props.product.price,
  productDescription: props.product.description,
  productImage: props.product.image,
  productID: props.product.id,
});
watch(
  () => props.product,
  (newProduct) => {
    form.value.productName = newProduct.name;
    form.value.productPrice = newProduct.price;
    form.value.productDescription = newProduct.description;
    form.value.productImage = newProduct.image;
    form.value.productID = newProduct.id;
  }
);

const emits = defineEmits(["update:modelValue"]);

const close = () => {
  emits("update:modelValue", false);
};


</script>
