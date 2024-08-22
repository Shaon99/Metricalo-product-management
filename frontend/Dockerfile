# Use Node.js v20.14.0 as the base image
FROM node:20.14.0-alpine

# Set the working directory inside the container
WORKDIR /app

# Install dependencies only if package.json or package-lock.json changes
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application code into the container
COPY . .

# Expose the port that the Vite server will run on
EXPOSE 3000

# Command to start the Vite development server
CMD ["npm", "run", "dev", "--", "--host"]
