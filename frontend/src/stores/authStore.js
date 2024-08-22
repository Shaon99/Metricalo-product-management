import { defineStore } from "pinia";
import apiClient from "../axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Swal from "sweetalert2";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem("token") || "",
    formErrors: {},
    isLoading: false,
    isButtonLoading: false,
    userLoading: false,
  }),
  getters: {
    isAuthenticated(state) {
      return !!state.token;
    },
  },
  actions: {
    //Register Trigger Events
    async handleRegister(data) {
      this.isButtonLoading = true;
      try {
        await apiClient.post("/api/register", data);
        toast.success("Registration successful. Please sign in", {
          theme: "dark",
          position: "bottom-right",
          duration: 3000,
        });
        setTimeout(() => {
          this.router.push("/");
          this.isButtonLoading = false;
        }, 2000);
      } catch (error) {
        this.handleError(error);
      } finally {
        this.isButtonLoading = false;
      }
    },

    //Login Trigger Events
    async handleLogin(data) {
      this.isButtonLoading = true;
      try {
        await this.getCsrfToken();
        const response = await apiClient.post("/api/login", data);
        this.token = response.data.token;
        localStorage.setItem("token", this.token);
        apiClient.defaults.headers.common[
          "Authorization"
        ] = `Bearer ${this.token}`;
        await this.getUser();
        this.router.push("/dashboard");
      } catch (error) {
        this.handleError(error);
      } finally {
        this.isButtonLoading = false;
      }
    },

    // getCsrfToken Trigger Events
    async getCsrfToken() {
      try {
        await apiClient.get("/sanctum/csrf-cookie");
      } catch (error) {
        console.error("Error getting CSRF token:", error);
      }
    },

    // get auth user Trigger Events
    async getUser() {
      this.userLoading = true;
      try {
        const response = await apiClient.get("/api/user", {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });
        this.user = response.data;
      } catch (error) {
        console.error("Failed to fetch user:", error);
        this.logout();
      } finally {
        this.userLoading = false;
      }
    },

    //logout: function
    logout() {
      Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out of your account.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, log out!",
        cancelButtonText: "Cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          this.handleLogout();
        }
      });
    },

    handleLogout() {
      this.isButtonLoading = true;
      toast.success("Successfully logged out...", {
        theme: "dark",
        position: "bottom-right",
        duration: 3000,
      });
      
      setTimeout(() => {
        this.clearAuthData();
        this.router.push("/");
      }, 1500);
    },

    //clear  auth data
    clearAuthData() {
      this.user = null;
      this.token = "";
      localStorage.removeItem("token");
      delete apiClient.defaults.headers.common["Authorization"];
      this.isButtonLoading = false;
    },

    // handle Api errors
    handleError(error) {
      if (error.response?.data?.errors) {
        this.formErrors = error.response.data.errors;
      }
    },
  },
});
