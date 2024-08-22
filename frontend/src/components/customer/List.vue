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
                >Customers Listing</span
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
                <div class="text-green-400 hidden sm:hidden lg:block md:block">
                  Uploading, please wait...
                </div>
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
                @click="handleAddCustomerClick"
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
                  <th scope="col" class="px-4 py-3">First Name</th>
                  <th scope="col" class="px-4 py-3">Last Name</th>
                  <th scope="col" class="px-4 py-3">Email</th>
                  <th scope="col" class="px-4 py-3">Phone</th>
                  <th scope="col" class="px-4 py-3">Address</th>
                  <th scope="col" class="px-4 py-3">Created AT</th>
                </tr>
              </thead>
              <tbody>
                <!-- Loading Indicator -->
                <tr v-if="customerStore.isLoading">
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
                    !customerStore.isLoading &&
                    customerStore.allCustomer.length === 0
                  "
                >
                  <td
                    colspan="8"
                    class="py-8 text-center text-white dark:text-white"
                  >
                    No record found
                  </td>
                </tr>

                <!-- Product Rows -->
                <tr
                  v-else
                  class="border-b dark:border-gray-700"
                  v-for="(customer, index) in customerStore.allCustomer"
                  :key="customer.id"
                >
                  <td class="px-4 py-3">
                    {{ (customerStore.currentPage - 1) * 10 + index + 1 }}
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
                            @click="handleEditClick(customer)"
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
                            @click="deleteCustomer(customer.id)"
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
                  <td class="px-4 py-3">{{ customer.first_name }}</td>
                  <td class="px-4 py-3">{{ customer.last_name ?? "N/A" }}</td>
                  <td class="px-4 py-3">{{ customer.email }}</td>
                  <td class="px-4 py-3">{{ customer.phone }}</td>
                  <td class="px-4 py-3">
                    {{ customer.address ?? "N/A" }}
                  </td>
                  <td class="px-4 py-3">
                    {{ formatDate(customer.created_at) ?? "N/A" }}
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- pagination -->
            <nav
              v-if="customerStore.allCustomer.length > 0"
              class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
            >
              <span
                class="text-sm font-normal text-gray-500 dark:text-gray-400"
              >
                Showing
                <span class="font-semibold text-gray-900 dark:text-white">
                  {{
                    customerStore.allCustomer.length === 0
                      ? 0
                      : (customerStore.currentPage - 1) * 10 + 1
                  }}-{{
                    Math.min(
                      customerStore.currentPage * 10,
                      customerStore.allCustomer.length
                    )
                  }}
                </span>
                of
                <span class="font-semibold text-gray-900 dark:text-white">{{
                  customerStore.allCustomer.length
                }}</span>
              </span>

              <ul class="inline-flex items-stretch -space-x-px">
                <!-- Previous Page Button -->
                <li>
                  <a
                    @click.prevent="
                      customerStore.goToPage(customerStore.currentPage - 1)
                    "
                    :disabled="customerStore.currentPage === 1"
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
                <li v-for="page in customerStore.totalPages" :key="page">
                  <a
                    @click.prevent="customerStore.goToPage(page)"
                    :class="{
                      'bg-blue-700 text-white':
                        page === customerStore.currentPage,
                      'text-gray-500 bg-white':
                        page !== customerStore.currentPage,
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
                      customerStore.goToPage(customerStore.currentPage + 1)
                    "
                    :disabled="
                      customerStore.currentPage === customerStore.totalPages
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
  <AddCustomerModal
    v-show="Utilities.addCustomerModal"
    v-model="Utilities.addCustomerModal"
    ref="addCustomerModalRef"
  />
  <EditCustomerModal
    v-show="Utilities.editCustomerModal"
    v-model="Utilities.editCustomerModal"
    :customer="Utilities.customer"
  />
  <!-- End block -->
</template>
<script setup>
import { ref, onMounted, watch } from "vue";
import { DotIcon, EditIcon, DeleteIcon, Loading } from "../../assets";
import { formatDate } from "../../utilities";
import { useCustomerStore } from "../../stores/customerStore";
import AddCustomerModal from "./AddCustomerModal.vue";
import EditCustomerModal from "./EditCustomerModal.vue";
import apiClient from "../../axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const customerStore = useCustomerStore();

const Utilities = ref({
  addCustomerModal: false,
  editCustomerModal: false,
  customer: {},
});
const actionIndex = ref(-1);
const addCustomerModalRef = ref(null);

const resetAddCustomerModal = () => {
  if (addCustomerModalRef.value) {
    addCustomerModalRef.value.resetForm();
  }
};

const handleAddCustomerClick = () => {
  Utilities.value.addCustomerModal = true;
  resetAddCustomerModal();
  customerStore.formErrors = {};
};

const actionToggle = (index) => {
  if (actionIndex.value === index) {
    actionIndex.value = -1;
  } else {
    actionIndex.value = index;
  }
};

const deleteCustomer = (customerId) => {
  actionIndex.value = -1;
  customerStore.deleteCustomer(customerId);
};

const handleEditClick = (customer) => {
  Utilities.value.editCustomerModal = true;
  actionIndex.value = -1;
  Utilities.value.customer = { ...customer };
  customerStore.formErrors = {};
};

onMounted(async () => {
  await customerStore.fetchAllCustomer();
});
watch(
  () => customerStore.closeModal,
  async (newVal) => {
    if (newVal) {
      customerStore.closeModal = false;
      Utilities.value.addCustomerModal = false;
      Utilities.value.editCustomerModal = false;
      resetAddCustomerModal();
      try {
        await customerStore.fetchAllCustomer();
        customerStore.formErrors = {};
      } catch (error) {
        console.error("Error fetching customers:", error);
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
      "/api/customers/import-customers",
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );
    if (response.data.skipped_rows && response.data.skipped_rows.length > 0) {
      const skippedRowsMessages = response.data.skipped_rows
        .map((row) => `Row ${row.row}: ${row.reason}`)
        .join("\n");

      toast.warn(
        `Import completed with some skipped rows:\n${skippedRowsMessages}`,
        {
          position: "top-right",
          autoClose: 5000,
          hideProgressBar: false,
          closeOnClick: true,
          pauseOnHover: true,
          draggable: true,
          progress: undefined,
        }
      );
    } else {
      toast.success(response.data.message, {
        theme: "dark",
        position: "top-right",
        duration: 3000,
      });
    }
  } catch (err) {
    console.error(err);
  } finally {
    try {
      await customerStore.fetchAllCustomer();
    } catch (fetchError) {
      console.error("Error fetching customers after upload:", fetchError);
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
  if (customerStore.allCustomer.length === 0) {
    toast.warn("no record found", {
      theme: "dark",
      position: "top-right",
      duration: 3000,
    });
    downloadLoading.value = false;
    return;
  }
  try {
    const response = await apiClient.get("/api/customers/export-customers", {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
      responseType: "blob",
    });

    const blob = new Blob([response.data], { type: "text/csv" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "customers.csv";
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
