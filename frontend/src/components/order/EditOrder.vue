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
                v-if="singleOrder && singleOrder.customer"
                class="ms-1 text-sm font-medium text-blue-600 md:ms-2 dark:text-blue-600"
              >
                Order Edit For: {{ singleOrder.customer.full_name }}
                <span class="text-gray-800 font-bold ml-2"
                  >OrderID#{{ singleOrder.id }}</span
                >
              </span>
              <span
                v-else
                class="ms-1 animate-pulse text-sm font-medium text-blue-600 md:ms-2 dark:text-blue-600"
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
                  singleOrder.status
                )}`"
              >
                {{ getStatusText(singleOrder.status) }}
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
                      @click="updateStatus(singleOrder.id,0)"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer"
                    >
                      Processing
                    </div>
                  </li>
                  <li>
                    <div
                      @click="updateStatus(singleOrder.id,1)"
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

          <div v-else>
            <form
              class="space-y-4"
              @submit.prevent="orderStore.orderUpdate(order)"
            >
              <!-- Customer Selection -->
              <div class="mb-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-1">
                  <label
                    for="customer_id"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                  >
                    Customer
                  </label>
                  <select
                    v-model="order.customer_id"
                    id="customer_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:placeholder-gray-100"
                  >
                    <option
                      v-for="customer in customerStore.allCustomer"
                      :key="customer.id"
                      :value="customer.id"
                    >
                      {{
                        customer.first_name + " " + customer.last_name || "N/A"
                      }}
                    </option>
                  </select>
                  <div
                    v-if="orderStore.formErrors.customer_id"
                    class="text-red-500 text-sm"
                  >
                    {{ orderStore.formErrors.customer_id[0] }}
                  </div>
                </div>
                <div class="col-span-1 bg-gray-200 rounded-md">
                  <div
                    class="flex justify-center items-center text-center py-4 font-bold text-xl text-gray-700 dark:text-gray-700"
                  >
                    <span>Total Amount:</span>
                    <span class="mx-2">${{ totalAmount }}</span>
                  </div>
                </div>
              </div>

              <!-- Product Items -->
              <div class="py-2">
                <div class="flex justify-end">
                  <button
                    @click="addItem"
                    type="button"
                    class="w-1/4 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-xl hover:bg-blue-700 focus:outline-none"
                  >
                    Add Item
                  </button>
                </div>
                <label
                  for="item"
                  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                  >Order Items</label
                >
                <div
                  v-if="orderStore.formErrors.items"
                  class="text-red-500 text-sm mb-2"
                >
                  <!-- Handle errors for items array, for example -->
                  <div
                    v-for="(error, index) in orderStore.formErrors.items"
                    :key="index"
                  >
                    {{ error }}
                  </div>
                </div>
                <div class="overflow-x-auto overflow-y-auto max-h-64">
                  <table
                    class="min-w-full text-sm text-left text-gray-200 dark:text-gray-300"
                  >
                    <thead
                      class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300"
                    >
                      <tr>
                        <th scope="col" class="px-4 py-4">Product</th>
                        <th scope="col" class="px-4 py-3 text-center">
                          Quantity
                        </th>
                        <th scope="col" class="px-4 py-3">Price</th>
                        <th scope="col" class="px-4 py-3">Total</th>
                        <th scope="col" class="px-4 py-3"></th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                      <tr v-for="(item, index) in order.items" :key="index">
                        <td class="px-4 py-3">
                          <select
                            v-model="item.product_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:placeholder-gray-100"
                            required
                          >
                            <option
                              v-for="product in productStore.allProduct"
                              :key="product.id"
                              :value="product.id"
                              :disabled="
                                order.items.some(
                                  (item) => item.product_id === product.id
                                )
                              "
                              :class="{
                                'text-red-400': order.items.some(
                                  (item) => item.product_id === product.id
                                ),
                                'text-gray-100': !order.items.some(
                                  (item) => item.product_id === product.id
                                ),
                              }"
                            >
                              {{ product.name }}
                            </option>
                          </select>
                        </td>
                        <td class="px-4 py-3 text-center">
                          <input
                            v-model.number="item.quantity"
                            type="number"
                            min="1"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:placeholder-gray-100 mx-auto"
                            required
                          />
                        </td>

                        <td class="px-4 py-3">
                          ${{ getProductPrice(item.product_id) }}
                        </td>
                        <td class="px-4 py-3">
                          ${{
                            item.quantity * getProductPrice(item.product_id)
                          }}
                        </td>
                        <td class="px-4 py-3">
                          <button @click="removeItem(index)" type="button">
                            <img
                              :src="DeleteIcon"
                              class="w-5 h-5 mr-2"
                              alt="delete"
                            />
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- Submit Button -->
              <div class="border-t-2 border-gray-300 flex justify-end">
                <LoadingButton
                  :isButtonLoading="orderStore.isButtonLoading"
                  buttonText="Update Order"
                  buttonType="submit"
                  buttonClasses="w-1/4 mt-4 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-xl hover:bg-blue-700 focus:outline-none"
                />
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>
<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { DeleteIcon, Loading } from "../../assets";
import LoadingButton from "../button/LoadingButton.vue";
import { useCustomerStore } from "../../stores/customerStore";
import { useProductStore } from "../../stores/productStore";
import { useOrderStore } from "../../stores/orderStore";
import { getStatusClass, getStatusText } from "../../utilities";
import apiClient from "../../axios";
import { useRoute } from "vue-router";
const customerStore = useCustomerStore();
const productStore = useProductStore();
const orderStore = useOrderStore();
const route = useRoute();
const orderId = route.params.id;
const singleOrder = ref([]);
const loading = ref(true);
const error = ref(null);
const showStatusDropdown = ref(false);
const toggleStatusDropdown = () => {
  showStatusDropdown.value = !showStatusDropdown.value;
};

const updateStatus = async (orderId, newVal) => {
  try {
    await orderStore.updateStatus(orderId, newVal);
    singleOrder.value.status = newVal;
    showStatusDropdown.value = false;
  } catch (error) {
    console.error("Error updating status:", error);
  }
};

const order = ref({
  customer_id: null,
  total_amount: null,
  items: [],
  orderId: orderId,
});

watch(
  () => singleOrder.value?.customer_id,
  (newCustomerId) => {
    order.value.customer_id = newCustomerId;
  }
);

watch(
  () => singleOrder.value?.order_items,
  (newOrderItems) => {
    order.value.items = newOrderItems;
  },
  { deep: true }
);

const totalAmount = computed(() => {
  return order.value.items
    .reduce((total, item) => {
      const price = getProductPrice(item.product_id);
      return total + item.quantity * price;
    }, 0)
    .toFixed(2);
});

watch(totalAmount, (newTotalAmount) => {
  order.value.total_amount = parseFloat(newTotalAmount);
});

const getProductPrice = (productId) => {
  const product = productStore.allProduct.find((p) => p.id === productId);
  return product ? product.price : 0;
};

const addItem = () => {
  order.value.items.push({
    product_id: null,
    quantity: 1,
  });
};

const removeItem = (index) => {
  order.value.items.splice(index, 1);
};

onMounted(async () => {
  orderStore.formErrors = {};
  try {
    const response = await apiClient.get(`/api/orders/${orderId}`, {
      headers: {
        "Content-Type": "multipart/form-data",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    singleOrder.value = response.data;
  } catch (err) {
    error.value = err.message || "Failed to load order details";
  } finally {
    loading.value = false;
  }
  await customerStore.fetchAllCustomer();
  await productStore.fetchAllProduct();
});
</script>
