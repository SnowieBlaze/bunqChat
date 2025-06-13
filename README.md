# Bunq Chat Backend API

- The database/backend structure is simple, made in such a way to cover the functionalities asked for in the assignment.

## Database Schema

- Users: `id`, `username`
- Groups: `id`, `name`, `creator_id`
- Group Users: `user_id`, `group_id`
- Messages: `id`, `content`, `author_id`, `group_id`, `timestamp`

See the full schema in `src/database/schema.sql`.

## Run app

From project root, run `php -S localhost:8080 -t public`. Then, the API will be available at `http://localhost:8080`.

## Routes

### Users

- `POST /user`  
  Create a user.  
  Body: `{ "username": "test" }`

- `GET /user/{id}`  
  Get user by ID.

- `GET /user/username/{username}`  
  Get user by username.

### Groups

- `POST /group`  
  Create a group.  
  Body: `{ "name": "testgroup", "creator_id": 1 }`

- `GET /group/{id}`  
  Get group by ID.

- `GET /group/name/{name}`  
  Get group by name.

- `GET /groups/creator/{creator_id}`  
  List groups by creator.

- `GET /groups`  
  List all groups.

### Group Membership

- `POST /groupuser/add`  
  Add user to group.  
  Body: `{ "user_id": 1, "group_id": 2 }`

- `POST /groupuser/remove`  
  Remove user from group.  
  Body: `{ "user_id": 1, "group_id": 2 }`

- `GET /groupuser/group/{group_id}`  
  List users in a group.

- `GET /groupuser/is_member/{user_id}/{group_id}`  
  Check if user is in group.

### Messages

- `POST /message`  
  Send a message.  
  Body: `{ "content": "Hello", "author_id": 1, "group_id": 2 }`

- `GET /messages/group/{group_id}`  
  List all messages in a group.
