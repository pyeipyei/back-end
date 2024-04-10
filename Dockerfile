# Use the official Nginx base image
FROM nginx:latest

# Remove the default Nginx configuration file
# RUN rm /etc/nginx/conf.d/default.conf

# Copy custom Nginx configuration file
COPY ./nginx/app.conf /etc/nginx/conf.d/
COPY ./api-gateway/ /var/www/

# Expose the port on which Nginx will run
EXPOSE 80

# Command to start Nginx when the container is run
CMD ["nginx", "-g", "daemon off;"]
