import { defineStore } from "pinia";
import apiClient from "../axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Swal from "sweetalert2";
import { useAuthStore } from "../stores/authStore";

export const useOrderStore = defineStore("order", {
  state: () => ({
    isLoading: false,
    isButtonLoading: false,
    formErrors: {},
    allOrder: [],
    currentPage: 1,
    totalPages: 1,
  }),
  getters: {
    token() {
      return useAuthStore().token;
    },
  },
  actions: {
    async fetchAllOrder(page = 1) {
      this.isLoading = true;
      try {
        const response = await apiClient.get(`/api/orders?page=${page}`, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });
        this.allOrder = response.data.data;
        this.currentPage = response.data.current_page;
        this.totalPages = response.data.last_page;
      } catch (error) {
        console.error("Error fetching orders:", error);
      } finally {
        this.isLoading = false;
      }
    },
    async goToPage(page) {
      try {
        if (page > 0 && page <= this.totalPages) {
          await this.fetchAllOrder(page);
        }
      } catch (error) {
        console.error("Error fetching orders:", error);
      }
    },

    async storeOrder(data) {
      this.isButtonLoading = true;
      this.formErrors = {};
      try {
        const response = await apiClient.post("/api/orders/store", data, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });
        toast.success(response.data.message, {
          theme: "dark",
          position: "top-right",
          duration: 3000,
        });
        setTimeout(() => {
          this.router.push("/orders");
        }, 500);
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

    async orderUpdate(data) {
      this.isButtonLoading = true;
      this.formErrors = {};
      try {
        const response = await apiClient.post(
          `/api/orders/update/${data.orderId}`,
          data,
          {
            headers: {
              Authorization: `Bearer ${this.token}`,
            },
          }
        );
        toast.success(response.data.message, {
          theme: "dark",
          position: "top-right",
          duration: 3000,
        });
        setTimeout(() => {
          this.router.push("/orders");
        }, 500);
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

    async deleteOrder(orderId) {
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
          const response = await apiClient.delete(`/api/orders/${orderId}`, {
            headers: {
              Authorization: `Bearer ${this.token}`,
            },
          });
          this.allOrder = this.allOrder.filter((order) => order.id !== orderId);
          toast.success(response.data.message || "Order deleted successfully", {
            theme: "dark",
            position: "top-right",
            duration: 3000,
          });
        } catch (error) {
          console.error("Error deleting order:", error);
        } finally {
          this.isLoading = false;
        }
      }
    },

    async updateStatus(orderId, newStatus) {
      this.isLoading = true;
      try {
        const response = await apiClient.put(
          `/api/orders/status-update/${orderId}`,
          { status: newStatus },
          {
            headers: {
              Authorization: `Bearer ${this.token}`,
            },
          }
        );
        toast.success(response.data.message, {
          theme: "dark",
          position: "bottom-right",
          duration: 3000,
        });
      } catch (error) {
        console.error("Error updating order status:", error);
      } finally {
        this.isLoading = false;
      }
    },
  },
});
