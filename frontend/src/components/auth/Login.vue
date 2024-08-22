<template>
  <div class="bg-white">
    <div class="grid items-center lg:grid-cols-4 md:grid-cols-3">
      <form
        class="max-w-lg w-full p-6 mx-auto lg:col-span-3 md:col-span-2"
        @submit.prevent="authStore.handleLogin(form)"
      >
        <div class="mb-12">
          <h3 class="text-4xl font-extrabold text-gray-800">Sign In</h3>
          <p class="mt-6 text-sm leading-relaxed text-gray-800">
            Welcome back! Please sign in to access your account and explore a
            world of possibilities. Your journey begins here.
          </p>
        </div>

        <div class="relative flex items-center">
          <label
            class="absolute top-[-9px] left-[18px] bg-white px-2 text-[13px] font-semibold text-gray-800"
            >Email</label
          >
          <input
            type="email"
            placeholder="Enter email"
            v-model="form.email"
            class="w-full py-3.5 px-4 text-sm border-2 rounded-md outline-none bg-white border-gray-200 focus:border-blue-600"
          />
          <img
            :src="Email"
            class="absolute right-4 w-[18px] h-[18px]"
            alt="Email Icon"
          />
        </div>
        <p
          v-if="authStore.formErrors.email"
          class="flex items-center mt-2 text-xs text-red-500"
        >
          <img :src="Check" class="mr-2 w-[14px] h-[14px]" alt="check" />
          <span>{{ authStore.formErrors.email[0] }}</span>
        </p>

        <div class="relative flex items-center mt-8">
          <label
            class="absolute top-[-9px] left-[18px] bg-white px-2 text-[13px] font-semibold text-gray-800"
            >Password</label
          >
          <input
            :type="showPassword ? 'text' : 'password'"
            placeholder="Enter password"
            v-model="form.password"
            class="w-full py-3.5 px-4 text-sm border-2 rounded-md outline-none bg-white border-gray-200 focus:border-blue-600"
          />
          <img
            @click="togglePasswordVisibility"
            :src="showPassword ? ClosedEye : Eye"
            class="absolute right-4 w-[18px] h-[18px] cursor-pointer"
            alt="Eye Icon"
          />
        </div>
        <p
          v-if="authStore.formErrors.password"
          class="flex items-center mt-2 text-xs text-red-500"
        >
          <img :src="Check" class="mr-2 w-[14px] h-[14px]" alt="check" />
          <span>{{ authStore.formErrors.password[0] }}</span>
        </p>

        <div class="flex items-center justify-between gap-4 mt-4">
          <div class="flex items-center">
            <input
              id="remember-me"
              name="remember-me"
              type="checkbox"
              class="h-4 w-4 text-blue-600 border-gray-300 rounded-md focus:ring-blue-500"
            />
            <label for="remember-me" class="ml-3 text-sm text-gray-800"
              >Remember me</label
            >
          </div>
          <a
            href="javascript:void(0);"
            class="text-sm font-semibold text-blue-600 hover:underline"
            >Forgot Password?</a
          >
        </div>

        <div class="mt-12">
          <LoadingButton
            :isButtonLoading="authStore.isButtonLoading"
            buttonText="Sign in"
            buttonType="submit"
            buttonClasses="w-full px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-xl hover:bg-blue-700 focus:outline-none"
          />
        </div>

        <p class="mt-8 text-sm text-center text-gray-800">
          Don't have an account?
          <router-link
            :to="{ name: 'Register' }"
            class="font-semibold text-blue-600 underline hover:no-underline ml-1 whitespace-nowrap"
          >
            Sign up
          </router-link>
        </p>
      </form>

      <div
        class="flex flex-col justify-center space-y-16 px-4 py-4 min-h-full bg-gradient-to-r from-purple-500 to-blue-700 lg:px-8 md:h-screen max-md:mt-16"
      >
        <div>
          <h4 class="text-lg font-semibold text-white">
            Secure Authentication
          </h4>
          <p class="mt-2 text-[13px] text-white">
            Log in with your registered email and password securely.
          </p>
        </div>
        <div>
          <h4 class="text-lg font-semibold text-white">Remember Me</h4>
          <p class="mt-2 text-[13px] text-white">
            Enable the "Remember Me" option for a seamless login experience in
            future sessions.
          </p>
        </div>
        <div>
          <h4 class="text-lg font-semibold text-white">Forgot Password?</h4>
          <p class="mt-2 text-[13px] text-white">
            Easily recover your account by clicking on the "Forgot Password?"
            link.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import LoadingButton from "../button/loadingButton.vue";
import { ref } from "vue";
import { Email, Eye, Loading, Check, ClosedEye } from "../../assets";
import { useAuthStore } from "../../stores/authStore";
const authStore = useAuthStore();
const showPassword = ref(false);

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

const form = ref({
  email: "",
  password: "",
});
</script>
