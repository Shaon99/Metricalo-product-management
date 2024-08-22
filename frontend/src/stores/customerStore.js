import { defineStore } from "pinia";
import apiClient from "../axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Swal from "sweetalert2";
import { useAuthStore } from "../stores/authStore";

export const useCustomerStore = defineStore("customer", {
  state: () => ({
    isLoading: false,
    isButtonLoading: false,
    closeModal: false,
    formErrors: {},
    allCustomer: [],
    currentPage: 1,
    totalPages: 1,
  }),
  getters: {
    token() {
      return useAuthStore().token;
    },
  },
  actions: {
    async fetchAllCustomer(page = 1) {
      this.isLoading = true;
      try {
        const response = await apiClient.get(`/api/customers?page=${page}`, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });
        this.allCustomer = response.data.data;
        this.currentPage = response.data.current_page;
        this.totalPages = response.data.last_page;
      } catch (error) {
        console.error("Error fetching customers:", error);
      } finally {
        this.isLoading = false;
      }
    },
    async goToPage(page) {
      try {
        if (page > 0 && page <= this.totalPages) {
          await this.fetchAllCustomer(page);
        }
      } catch (error) {
        console.error("Error fetching customers:", error);
      }
    },

    async storeCustomer(data) {
      this.isButtonLoading = true;
      try {
        const formData = new FormData();
        formData.append("first_name", data.first_name);
        formData.append("last_name", data.last_name);
        formData.append("email", data.email);
        formData.append("phone", data.phone);
        formData.append("address", data.address);
        const response = await apiClient.post(
          "/api/customers/store",
          formData,
          {
            headers: {
              Authorization: `Bearer ${this.token}`,
              "Content-Type": "multipart/form-data",
            },
          }
        );
        this.closeModal = true;
        toast.success(response.data.message, {
          theme: "dark",
          position: "top-right",
          duration: 3000,
        });
      } catch (error) {
        if (
          error.response &&
          error.response.data &&
          error.response.data.errors
        ) {
          this.formErrors = error.response.data.errors;
        }
      } finally {
        this.isButtonLoading = false;
      }
    },

    async updateCustomer(data) {
      this.isButtonLoading = true;
      try {
        const formData = new FormData();
        formData.append("first_name", data.first_name);
        formData.append("last_name", data.last_name);
        formData.append("email", data.email);
        formData.append("phone", data.phone);
        formData.append("address", data.address);
        const response = await apiClient.post(
          `/api/customers/update/${data.customerID}`,
          formData,
          {
            headers: {
              Authorization: `Bearer ${this.token}`,
              "Content-Type": "multipart/form-data",
            },
          }
        );
        toast.success(response.data.message, {
          theme: "dark",
          position: "top-right",
          duration: 3000,
        });
        this.closeModal = true;
      } catch (error) {
        if (
          error.response &&
          error.response.data &&
          error.response.data.errors
        ) {
          this.formErrors = error.response.data.errors;
        }
      } finally {
        this.isButtonLoading = false;
      }
    },

    async deleteCustomer(customerId) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "Are you sure you want to delete this item? This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Delete it!",
        cancelButtonText: "Cancel",
      });

      if (result.isConfirmed) {
        this.isLoading = true;
        try {
          const response = await apiClient.delete(
            `/api/customers/${customerId}`,
            {
              headers: {
                Authorization: `Bearer ${this.token}`,
              },
            }
          );
          this.allCustomer = this.allCustomer.filter(
            (customer) => customer.id !== customerId
          );
          toast.success(
            response.data.message || "Customer deleted successfully",
            {
              theme: "dark",
              position: "top-right",
              duration: 3000,
            }
          );
        } catch (error) {
          console.error("Error deleting customer:", error);
        } finally {
          this.isLoading = false;
        }
      }
    },
  },
});
