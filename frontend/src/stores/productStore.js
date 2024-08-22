import { defineStore } from "pinia";
import apiClient from "../axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Swal from "sweetalert2";
import { useAuthStore } from "../stores/authStore";

export const useProductStore = defineStore("product", {
  state: () => ({
    isLoading: false,
    isButtonLoading: false,
    closeModal: false,
    formErrors: {},
    allProduct: [],
    currentPage: 1,
    totalPages: 1,
  }),
  getters: {
    token() {
      return useAuthStore().token;
    },
  },
  actions: {
    async fetchAllProduct(page = 1) {
      this.isLoading = true;
      try {
        const response = await apiClient.get(`/api/products?page=${page}`, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });
        this.allProduct = response.data.data;
        this.currentPage = response.data.current_page;
        this.totalPages = response.data.last_page;
      } catch (error) {
        console.error("Error fetching products:", error);
      } finally {
        this.isLoading = false;
      }
    },
    async goToPage(page) {
      try {
        if (page > 0 && page <= this.totalPages) {
          await this.fetchAllProduct(page);
        }
      } catch (error) {
        console.error("Error fetching products:", error);
      }
    },

    async storeProduct(data) {
      this.isButtonLoading = true;
      try {
        const formData = new FormData();
        formData.append("name", data.name);
        formData.append("price", data.price);
        formData.append("description", data.description);
        formData.append("file", data.picture);
        const response = await apiClient.post("/api/products/store", formData, {
          headers: {
            Authorization: `Bearer ${this.token}`,
            "Content-Type": "multipart/form-data",
          },
        });
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

    async updateProduct(data) {
      this.isButtonLoading = true;
      try {
        const formData = new FormData();
        formData.append("name", data.productName);
        formData.append("price", data.productPrice);
        formData.append("description", data.productDescription);
        formData.append("file", data.productImage);
        const response = await apiClient.post(
          `/api/products/update/${data.productID}`,
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

    async deleteProduct(productId) {
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
            `/api/products/${productId}`,
            {
              headers: {
                Authorization: `Bearer ${this.token}`,
              },
            }
          );
          this.allProduct = this.allProduct.filter(
            (product) => product.id !== productId
          );
          toast.success(
            response.data.message || "Product deleted successfully",
            {
              theme: "dark",
              position: "top-right",
              duration: 3000,
            }
          );
        } catch (error) {
          console.error("Error deleting product:", error);
        } finally {
          this.isLoading = false;
        }
      }
    },
  },
});
