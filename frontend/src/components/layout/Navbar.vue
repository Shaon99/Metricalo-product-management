<template>
  <nav
    class="fixed top-0 z-50 w-full bg-gradient-to-r from-purple-500 to-blue-700"
  >
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start rtl:justify-end">
          <button
            @click="toggleSidebar"
            type="button"
            class="inline-flex items-center p-2 text-sm text-gray-100 rounded-lg sm:hidden"
          >
            <svg
              v-if="!isSidebarOpen"
              class="w-6 h-6"
              aria-hidden="true"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
              ></path>
            </svg>
            <svg
              v-if="isSidebarOpen"
              class="w-6 h-6"
              aria-hidden="true"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
          <router-link :to="{ name: 'Dashboard' }" class="flex ms-2 md:me-24">
            <span
              class="self-center uppercase text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white"
              >Metricalo</span
            >
          </router-link>
        </div>

        <div class="relative">
          <button
            @mouseover="showDropdown = true"
            @mouseleave="showDropdown = false"
            class="flex items-center"
          >
            <img
              src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
              alt="Profile"
              class="w-10 h-10 rounded-full"
            />
          </button>
          <!-- Dropdown Menu -->
          <div
            v-show="showDropdown"
            class="absolute right-0 w-48 bg-white text-gray-700 rounded-lg shadow-lg"
            @mouseover="showDropdown = true"
            @mouseleave="showDropdown = false"
          >
            <ul class="list-none p-2">
              <li>
                <p class="block px-4 py-2 hover:bg-gray-200">
                  {{ authStore.user ? authStore.user.name : "N/A" }}
                </p>
              </li>
              <li>
                <p class="block px-4 py-2 hover:bg-gray-200">
                  {{ authStore.user ? authStore.user.email : "N/A" }}
                </p>
              </li>
              <li>
                <a
                  @click="logout"
                  v-if="!authStore.isButtonLoading"
                  href="#"
                  class="block px-4 py-2 hover:bg-gray-200"
                  >Sign out</a
                >

                <span v-else
                  ><img
                    :src="Loading"
                    class="inline w-4 h-4 mr-3 animate-spin"
                    alt="loading"
                  />
                  Signing out...
                </span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-gradient-to-r from-purple-500 to-blue-700 sm:translate-x-0 sm:translate-x-0"
    :class="{
      '-translate-x-full': !isSidebarOpen,
      'translate-x-0': isSidebarOpen,
    }"
  >
    <div
      class="h-full px-3 pb-4 overflow-y-auto bg-gradient-to-r from-purple-500 to-blue-700"
    >
      <button
        @click="toggleSidebar"
        class="fixed top-4 left-4 p-2 text-white bg-gray-800 rounded-md sm:hidden"
      >
        <svg
          class="w-6 h-6"
          fill="#000"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>
      <ul class="space-y-2 font-medium">
        <li>
          <router-link
            :to="{ name: 'Dashboard' }"
            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
            :class="{
              'bg-gray-200 dark:bg-gray-600': $route.name === 'Dashboard',
            }"
          >
            <img :src="Dashboard" class="inline w-5 h-5 me-3" alt="dashboard" />
            <span class="ms-3">Dashboard</span>
          </router-link>
        </li>

        <li>
          <router-link
            :to="{ name: 'Products' }"
            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
            :class="{
              'bg-gray-200 dark:bg-gray-600': $route.name === 'Products',
            }"
          >
            <img :src="Products" class="inline w-5 h-5 me-3" alt="products" />
            <span class="ms-3">Products</span>
          </router-link>
        </li>

        <li>
          <router-link
            :to="{ name: 'Customers' }"
            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
            :class="{
              'bg-gray-200 dark:bg-gray-600': $route.name === 'Customers',
            }"
          >
            <img :src="Customer" class="inline w-5 h-5 me-3" alt="customers" />
            <span class="ms-3">Customers</span>
          </router-link>
        </li>

        <li>
          <router-link
            :to="{ name: 'Orders' }"
            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
            :class="{
              'bg-gray-200 dark:bg-gray-600': $route.name === 'Orders'|| $route.name === 'createOrder' || $route.name === 'OrderDetails'|| $route.name === 'EditOrder',
            }"
          >
            <img :src="Order" class="inline w-5 h-5 me-3" alt="orders" />
            <span class="ms-3">Orders</span>
          </router-link>
        </li>

        <li>
          <LoadingButton
            buttonClasses="w-full flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
            :isButtonLoading="authStore.isButtonLoading"
            buttonText="Sign Out"
            loadingText="Signing out..."
            buttonType="button"
            :Icon="Signout"
            @click="logout"
          />
        </li>
      </ul>
    </div>
  </aside>
</template>
<script setup>
import { ref } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { Dashboard, Signout, Products, Customer, Order } from "../../assets";
import LoadingButton from "../button/LoadingButton.vue";

const authStore = useAuthStore();
const isSidebarOpen = ref(false);
const showDropdown = ref(false);

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const logout = () => {
  authStore.logout();
};
</script>
