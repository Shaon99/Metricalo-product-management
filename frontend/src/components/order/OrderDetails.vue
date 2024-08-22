<template lang="html">
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
                v-if="order && order.customer"
                class="ms-1 text-sm font-medium text-blue-600 md:ms-2 dark:text-blue-600"
              >
                Order details for: {{ order.customer.full_name }}
              </span>
              <span
                v-else
                class="text-xs animate-pulse font-medium px-2.5 text-blue-600 md:ms-2 dark:text-blue-600"
              >
                Loading...
              </span>
            </div>
          </li>
        </ol>
      </nav>
      <!-- End Breadcrumb -->

      <section>
        <div
          class="bg-white p-4 dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden"
        >
          <div
            class="flex flex-col md:flex-row items-center justify-between md:justify-end bg-gray-800 rounded-lg py-2 pb-4"
          >
            <!-- Status Label and Display -->
            <div class="flex items-center mb-4 md:mb-0 md:mr-4">
              <label for="status" class="text-gray-200 text-md mr-2"
                >Status:</label
              >
              <span
                v-if="loading || orderStore.isLoading"
                class="text-xs font-medium px-2.5 py-0.5 rounded bg-gray-400 animate-pulse"
              >
                Loading...
              </span>

              <span
                v-else
                :class="`text-xs font-medium px-2.5 py-0.5 rounded ${getStatusClass(
                  order.status
                )}`"
              >
                {{ getStatusText(order.status) }}
              </span>
            </div>

            <div class="relative">
              <button
                @click="toggleStatusDropdown"
                class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                type="button"
              >
                Change status
                <svg
                  class="w-2.5 h-2.5 ms-3"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 10 6"
                >
                  <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 4 4 4-4"
                  />
                </svg>
              </button>
              <!-- Status Dropdown (Hidden by Default) -->
              <div
                v-if="showStatusDropdown"
                class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 absolute"
              >
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                  <li>
                    <div
                      @click="updateStatus(order.id, 0)"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer"
                    >
                      Processing
                    </div>
                  </li>
                  <li>
                    <div
                      @click="updateStatus(order.id, 1)"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer"
                    >
                      Delivered
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <!-- Back to Orders Button -->
            <router-link
              :to="{ name: 'Orders' }"
              class="bg-blue-500 ml-4 text-white hover:bg-blue-600 disabled:bg-blue-300 font-medium rounded-lg px-4 py-2 text-center transition duration-150 ease-in-out"
              type="button"
            >
              Back to orders
            </router-link>
          </div>
          <div
            v-if="loading"
            class="flex justify-center py-24 space-x-2 items-center"
          >
            <img :src="Loading" class="w-4 h-4 animate-spin" alt="loading" />
            <div class="text-lg text-white">Loading, please wait...</div>
          </div>

          <div
            v-else-if="error"
            class="text-red-400 flex justify-center py-24 items-center"
          >
            Error loading order details: {{ error }}
          </div>

          <div
            v-else
            class="bg-white mb-4 dark:bg-gray-800 shadow rounded-lg p-6"
          >
            <div class="flex items-center space-x-4 mb-4">
              <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                Order #{{ order.id }}
              </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div
                class="border-b md:border-r md:border-b-0 border-gray-200 dark:border-gray-700 pb-4"
              >
                <h3
                  class="text-lg font-semibold text-gray-700 dark:text-gray-300"
                >
                  Customer Information
                </h3>
                <p class="text-gray-600 mt-4 dark:text-gray-300 flex">
                  <span
                    ><img
                      :src="User"
                      alt="user"
                      class="w-6 h-6 inline mr-2"
                    />{{ order.customer.full_name }}</span
                  >
                </p>
                <p class="text-blue-600 mt-2 dark:text-blue-300">
                  <span
                    ><img
                      :src="Email"
                      alt="email"
                      class="w-6 h-6 inline mr-2"
                    />{{ order.customer.email }}</span
                  >
                </p>
                <p class="text-gray-600 mt-2 dark:text-gray-300">
                  <span
                    ><img
                      :src="Phone"
                      alt="phone"
                      class="w-6 h-6 inline mr-2"
                    />{{ order.customer.phone }}</span
                  >
                </p>
              </div>

              <div class="border-b pb-4">
                <h3
                  class="text-lg font-semibold text-gray-700 dark:text-gray-300"
                >
                  Shipping Address
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                  {{ order.customer.address }}
                </p>
              </div>
            </div>

            <div class="mt-6">
              <h3
                class="text-lg font-semibold text-gray-700 dark:text-gray-300"
              >
                Order Items
              </h3>
              <ul>
                <li
                  v-for="item in order.order_items"
                  :key="item.id"
                  class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 py-2"
                >
                  <div class="flex items-center space-x-6">
                    <img
                      v-if="item.product.image"
                      :src="item.product.image"
                      :alt="item.product.name"
                      class="w-12 h-12 object-cover rounded"
                    />
                    <span class="text-gray-600 dark:text-gray-300">
                      {{ item.product.name }} (x{{ item.quantity }})
                    </span>
                  </div>
                  <span class="font-semibold text-gray-900 dark:text-gray-100">
                    ${{ item.product.price }}
                  </span>
                </li>
              </ul>
            </div>

            <div class="flex justify-between items-center mt-6">
              <span class="text-lg font-bold text-gray-900 dark:text-gray-100"
                >Total:</span
              >
              <span class="text-lg font-bold text-gray-900 dark:text-gray-100"
                >${{ order.total_amount }}</span
              >
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Loading, Email, User, Phone } from "../../assets";
import apiClient from "../../axios";
import { getStatusClass, getStatusText } from "../../utilities";
import { useRoute } from "vue-router";
import { useOrderStore } from "../../stores/orderStore";

const route = useRoute();
const orderId = route.params.id;

const orderStore = useOrderStore();

const order = ref(null);
const loading = ref(true);
const error = ref(null);

const showStatusDropdown = ref(false);

const toggleStatusDropdown = () => {
  showStatusDropdown.value = !showStatusDropdown.value;
};

const updateStatus = async (orderId, newVal) => {
  try {
    await orderStore.updateStatus(orderId, newVal);
    order.value.status = newVal;
    showStatusDropdown.value = false;
  } catch (error) {
    console.error("Error updating status:", error);
  }
};

onMounted(async () => {
  try {
    const response = await apiClient.get(`/api/orders/${orderId}`, {
      headers: {
        "Content-Type": "multipart/form-data",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    order.value = response.data;
  } catch (err) {
    error.value = err.message || "Failed to load order details";
  } finally {
    loading.value = false;
  }
});
</script>
