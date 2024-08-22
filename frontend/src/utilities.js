// utils.js
import { format } from "date-fns";

export const formatDate = (date) => {
  return format(new Date(date), "dd MMM, yyyy");
};

export function truncateDescription(description, wordLimit = 20) {
  const words = description.split(' ');
    if (words.length > wordLimit) {
      return words.slice(0, wordLimit).join(' ') + '...';
  }
    return description;
}

export const getStatusClass = (status) => {
  return status === 1
    ? "bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300"
    : "dark:bg-yellow-900 dark:text-yellow-300 g-yellow-100 text-yellow-800";
};

export const getStatusText = (status) => {
  return status === 1 ? "Delivered" : "Processing";
};
