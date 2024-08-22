<template>
  <!-- Start block -->
  <div class="p-2 md:p-2 lg:p-2 sm:ml-64">
    <div class="p-2 mt-12">
      <!-- Breadcrumb -->
      <nav class="flex pb-4 py-2">
        <ol
          class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse"
        >
          <li class="inline-flex items-center">
            <router-link
              :to="{ name: 'Dashboard' }"
              class="inline-flex items-center text-sm font-medium text-dark-700 hover:text-blue-600"
            >
              <svg
                class="w-3 h-3 me-2.5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"
                />
              </svg>
              Dashboard
            </router-link>
          </li>

          <li aria-current="page">
            <div class="flex items-center">
              <svg
                class="rtl:rotate-180 w-3 h-3 text-gray-500 mx-1"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 6 10"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="m1 9 4-4-4-4"
                />
              </svg>
              <span
                class="ms-1 text-sm font-medium text-blue-600 md:ms-2 dark:text-blue-600"
                >Products Listing</span
              >
            </div>
          </li>
        </ol>
      </nav>
      <!-- End Breadcrumb -->

      <section>
        <div
          class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden"
        >
          <div
            class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-6 bg-gray-800 rounded-lg shadow-md"
          >
            <!-- File Upload Section -->
            <div class="flex flex-col space-y-2">
              <div class="flex flex-row space-x-2">
                <input
                  type="file"
                  @change="handleFileUpload"
                  class="border w-1/2 bg-gray-200 border-gray-300 rounded-lg text-sm px-5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button
                  @click="uploadFile"
                  :disabled="loading"
                  class="bg-blue-500 text-white hover:bg-blue-600 disabled:bg-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center transition duration-150 ease-in-out"
                >
                  Upload CSV
                </button>
              </div>

              <!-- Loading indicator -->
              <div v-if="loading" class="flex items-center space-x-2">
                <img
                  :src="Loading"
                  class="w-4 h-4 animate-spin"
                  alt="loading"
                />
                <div class="text-green-400 hidden sm:hidden lg:block md:block">Uploading, please wait...</div>
              </div>

              <!-- Error message -->
              <div v-if="error" class="text-red-500">
                {{ error }}
              </div>
            </div>

            <div class="flex flex-row space-x-2">
              <!-- Download Button -->
              <button
                @click="downloadCsv"
                class="block text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                type="button"
              >
                <div v-if="downloadLoading">
                  <div class="flex items-center justify-center space-x-2">
                    <img
                      :src="Loading"
                      class="w-4 h-4 animate-spin"
                      alt="loading"
                    />
                    <div class="text-gray-200">downloading, please wait...</div>
                  </div>
                </div>
                <div v-else>Download CSV</div>
              </button>

              <!-- Add Product Button -->
              <button
                @click="handleAddProductClick"
                class="bg-blue-500 text-white hover:bg-blue-600 disabled:bg-blue-300 font-medium rounded-lg px-4 py-2 text-center transition duration-150 ease-in-out"
                type="button"
              >
                Add Product
              </button>
            </div>
          </div>

          <div class="overflow-x-auto">
            <!-- Product Table -->
            <table
              class="w-full text-sm text-left text-gray-200 dark:text-gray-300"
            >
              <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300"
              >
                <tr>
                  <th scope="col" class="px-4 py-4">#SL</th>
                  <th scope="col" class="px-4 py-3 text-start">Actions</th>
                  <th scope="col" class="px-4 py-3">Product Name</th>
                  <th scope="col" class="px-4 py-3">Price</th>
                  <th scope="col" class="px-4 py-3">Description</th>
                  <th scope="col" class="px-4 py-3">Image</th>
                  <th scope="col" class="px-4 py-3">Created AT</th>
                </tr>
              </thead>
              <tbody>
                <!-- Loading Indicator -->
                <tr v-if="productStore.isLoading">
                  <td colspan="7" class="py-8 text-center">
                    <div class="flex items-center justify-center space-x-2">
                      <img
                        :src="Loading"
                        class="w-8 h-8 animate-spin"
                        alt="loading"
                      />
                      <div class="text-lg text-white">
                        Loading, please wait...
                      </div>
                    </div>
                  </td>
                </tr>

                <!-- No Records Found State -->
                <tr
                  v-else-if="
                    !productStore.isLoading &&
                    productStore.allProduct.length === 0
                  "
                >
                  <td
                    colspan="7"
                    class="py-8 text-center text-white dark:text-white"
                  >
                    No record found
                  </td>
                </tr>

                <!-- Product Rows -->
                <tr
                  v-else
                  class="border-b dark:border-gray-700"
                  v-for="(product, index) in productStore.allProduct"
                  :key="product.id"
                >
                  <td class="px-4 py-3">
                    {{ (productStore.currentPage - 1) * 10 + index + 1 }}
                  </td>
                  <td class="px-4 py-3 text-start">
                    <button
                      @click="actionToggle(index)"
                      class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                      type="button"
                    >
                      <img :src="DotIcon" class="w-5 h-5" alt="dot" />
                    </button>
                    <div
                      v-show="actionIndex === index"
                      class="z-10 absolute bg-white rounded divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                    >
                      <ul class="py-1 text-sm">
                        <li>
                          <button
                            @click="handleEditClick(product)"
                            type="button"
                            class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200"
                          >
                            <img
                              :src="EditIcon"
                              class="w-5 h-5 mr-2"
                              alt="edit"
                            />
                            Edit
                          </button>
                        </li>
                        <li>
                          <button
                            @click="deleteProduct(product.id)"
                            type="button"
                            class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400"
                          >
                            <img
                              :src="DeleteIcon"
                              class="w-5 h-5 mr-2"
                              alt="delete"
                            />
                            Delete
                          </button>
                        </li>
                      </ul>
                    </div>
                  </td>
                  <td class="px-4 py-3">{{ product.name }}</td>
                  <td class="px-4 py-3">$ {{ product.price.toFixed(2) }} </td>
                  <td class="px-4 py-3 w-1/4">
                    {{ truncateDescription(product.description) }}
                  </td>
                  <td class="px-4 py-3">
                    <div class="flex items-center justify-center">
                      <img
                        v-if="product.image"
                        :src="product.image"
                        alt="img"
                        class="w-16 h-16 object-cover rounded-md shadow-sm"
                      />
                      <p v-else class="text-gray-500 text-sm">N/A</p>
                    </div>
                  </td>
                  <td class="px-4 py-3">
                    {{ formatDate(product.created_at) ?? "N/A" }}
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- pagination -->
            <nav
              v-if="productStore.allProduct.length > 0"
              class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
            >
              <span
                class="text-sm font-normal text-gray-500 dark:text-gray-400"
              >
                Showing
                <span class="font-semibold text-gray-900 dark:text-white">
                  {{
                    productStore.allProduct.length === 0
                      ? 0
                      : (productStore.currentPage - 1) * 10 + 1
                  }}-{{
                    Math.min(
                      productStore.currentPage * 10,
                      productStore.allProduct.length
                    )
                  }}
                </span>
                of
                <span class="font-semibold text-gray-900 dark:text-white">{{
                  productStore.allProduct.length
                }}</span>
              </span>

              <ul class="inline-flex items-stretch -space-x-px">
                <!-- Previous Page Button -->
                <li>
                  <a
                    @click.prevent="
                      productStore.goToPage(productStore.currentPage - 1)
                    "
                    :disabled="productStore.currentPage === 1"
                    href="#"
                    class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                  >
                    <span class="sr-only">Previous</span>
                    <svg
                      class="w-5 h-5"
                      aria-hidden="true"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10.293 15.293a1 1 0 0 1 0-1.414L13.586 11H4a1 1 0 0 1 0-2h9.586L10.293 6.121a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </a>
                </li>

                <!-- Page Number Buttons -->
                <li v-for="page in productStore.totalPages" :key="page">
                  <a
                    @click.prevent="productStore.goToPage(page)"
                    :class="{
                      'bg-blue-700 text-white':
                        page === productStore.currentPage,
                      'text-gray-500 bg-white':
                        page !== productStore.currentPage,
                    }"
                    class="flex items-center justify-center h-full px-3 py-1 text-sm font-medium border border-gray-300 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                  >
                    {{ page }}
                  </a>
                </li>

                <!-- Next Page Button -->
                <li>
                  <a
                    @click.prevent="
                      productStore.goToPage(productStore.currentPage + 1)
                    "
                    :disabled="
                      productStore.currentPage === productStore.totalPages
                    "
                    href="#"
                    class="flex items-center justify-center h-full py-1.5 px-3 text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                  >
                    <span class="sr-only">Next</span>
                    <svg
                      class="w-5 h-5"
                      aria-hidden="true"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M9.707 15.293a1 1 0 0 0 0-1.414L6.414 11H16a1 1 0 0 0 0-2H6.414l3.293-2.879a1 1 0 0 0-1.414-1.414l-4 4a1 1 0 0 0 0 1.414l4 4a1 1 0 0 0 1.414 0z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </section>
    </div>
  </div>
  <AddProductModal
    v-show="Utilities.addProductModal"
    v-model="Utilities.addProductModal"
    ref="addProductModalRef"
  />
  <EditProductModal
    v-show="Utilities.editProductModal"
    v-model="Utilities.editProductModal"
    :product="Utilities.product"
  />
  <!-- End block -->
</template>
<script setup>
import { ref, onMounted, watch } from "vue";
import { DotIcon, EditIcon, DeleteIcon, Loading } from "../../assets";
import { formatDate, truncateDescription } from "../../utilities";
import { useProductStore } from "../../stores/productStore";
import AddProductModal from "./AddProductModal.vue";
import EditProductModal from "./EditProductModal.vue";
import apiClient from "../../axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const productStore = useProductStore();

const Utilities = ref({
  addProductModal: false,
  editProductModal: false,
  product: {},
});
const actionIndex = ref(-1);
const addProductModalRef = ref(null);

const resetAddProductModal = () => {
  if (addProductModalRef.value) {
    addProductModalRef.value.resetForm();
  }
};

const handleAddProductClick = () => {
  Utilities.value.addProductModal = true;
  resetAddProductModal();
  productStore.formErrors = {};
};

const actionToggle = (index) => {
  if (actionIndex.value === index) {
    actionIndex.value = -1;
  } else {
    actionIndex.value = index;
  }
};

const deleteProduct = (productId) => {
  actionIndex.value = -1;
  productStore.deleteProduct(productId);
};

const handleEditClick = (product) => {
  Utilities.value.editProductModal = true;
  actionIndex.value = -1;
  Utilities.value.product = { ...product };
  productStore.formErrors = {};
};

onMounted(async () => {
  await productStore.fetchAllProduct();
});
watch(
  () => productStore.closeModal,
  async (newVal) => {
    if (newVal) {
      productStore.closeModal = false;
      Utilities.value.addProductModal = false;
      Utilities.value.editProductModal = false;
      resetAddProductModal();
      try {
        await productStore.fetchAllProduct();
        productStore.formErrors = {};
      } catch (error) {
        console.error("Error fetching products:", error);
      }
    }
  }
);

//import product
const file = ref(null);
const loading = ref(false);
const error = ref(null);
const downloadLoading = ref(false);

const handleFileUpload = (event) => {
  file.value = event.target.files[0];
};

const uploadFile = async () => {
  if (!file.value) {
    error.value = "Please select a file!";
    return;
  }

  const formData = new FormData();
  formData.append("file", file.value);
  loading.value = true;
  error.value = null;

  try {
    const response = await apiClient.post(
      "/api/products/import-products",
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );
    toast.success(response.data.message, {
      theme: "dark",
      position: "top-right",
      duration: 3000,
    });
  } catch (err) {
    console.error(err);
  } finally {
    try {
      await productStore.fetchAllProduct();
    } catch (fetchError) {
      console.error("Error fetching products after upload:", fetchError);
    } finally {
      loading.value = false;
      file.value = null;
      document.querySelector('input[type="file"]').value = null;
    }
  }
};
//export data
const downloadCsv = async () => {
  downloadLoading.value = true;
  if (productStore.allProduct.length === 0) {
    toast.warn("no record found", {
      theme: "dark",
      position: "top-right",
      duration: 3000,
    });
    downloadLoading.value = false;
    return;
  }
  try {
    const response = await apiClient.get("/api/products/export-products", {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
      responseType: "blob",
    });

    const blob = new Blob([response.data], { type: "text/csv" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "products.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } catch (error) {
    console.error("Error downloading the CSV file:", error);
  } finally {
    downloadLoading.value = false;
  }
};
</script>
