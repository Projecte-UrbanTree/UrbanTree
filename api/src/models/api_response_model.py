# Api success response:

# {
#   "status": "success",
#   "data": {
#     "id": 123,
#     "name": "John Doe",
#     "email": "john.doe@example.com"
#   }
# }


# Error response:
# {
#   "status": "error",
#   "message": "Validation failed",
#   "errors": {
#     "email": "Invalid email format",
#     "password": "Password must be at least 8 characters long"
#   }
# }

# Unique error response:
# {
#   "status": "error",
#   "message": "Resource not found",
#   "code": 404
# }
