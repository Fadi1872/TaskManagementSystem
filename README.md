## Task Management System

**Type:** Back-end API

### Project Name

`task-management-system`

### Description

A RESTful API for managing tasks with support for user roles, task statuses, priorities, and user activation.

---

### Requirements

1. **CRUD on Tasks**

   * **Admin**: create, update, delete, list all tasks, filter by user, status, title
   * **User**: list associated tasks, change status
2. **CRUD on Statuses**

   * **Admin**: create, update, delete (only if not associated with tasks), list all statuses
   * **User**: list statuses
3. **Task Priorities**

   * Priority table stores `name` and `level` (0–20) for ordering tasks
   * **Admin**: create, update, delete, list all priorities
   * **User**: list all priorities
4. **User Management**

   * Users can be deactivated; their data remains in tasks but deactivated users are hidden from user lists
   * **Admin**: create users, delete users, list all users, update own account, toggle user activation status
   * **User**: update own account
5. **Authentication**

   * **Admin**: create accounts, delete accounts, toggle activation status
   * **User**: log in, log out, update profile

---

### Tables

#### 1. users

* `id` (PK)
* `name` (string)
* `email` (string)
* `password` (string)
* `is_admin` (bool)
* `is_activated` (bool)
* *timestamps*

#### 2. statuses

* `id` (PK, AI)
* `name` (string, 40)
* *timestamps*

#### 3. priorities

* `id` (PK, AI)
* `name` (string, 40)
* `level` (integer, 0–20)
* *timestamps*

#### 4. tasks

* `id` (PK, AI)
* `title` (string, 255)
* `description` (text, 10000)
* `status_id` (FK ➔ statuses.id)
* `priority_id` (FK ➔ priorities.id)
* `created_by` (FK ➔ users.id)
* `start_date` (date)
* `due_date` (date)
* `completed_at` (date, nullable)
* *timestamps*

#### 5. task\_user (pivot)

* `user_id` (FK ➔ users.id)
* `task_id` (FK ➔ tasks.id)
* *PK: (user\_id, task\_id)*
* *timestamps*

---

### Relationships

* **Users ↔ Tasks**: many-to-many via `task_user`; a task is created by one user (`created_by`) and can be assigned to multiple users.
* **Tasks ↔ Statuses**: one-to-many; each task has one status via `status_id`.
* **Tasks ↔ Priorities**: one-to-many; each task has one priority via `priority_id`.

---

### User Roles & Permissions

| Role      | Permissions                                                                  |
| --------- | ---------------------------------------------------------------------------- |
| **Admin** | - Tasks: Create, Read, Update, Delete, Filter by user/status/title           |
|           | - Statuses: Create, Read, Update, Delete (if unused)                         |
|           | - Priorities: Create, Read, Update, Delete                                   |
|           | - Users: Create, Read, Update own account, Delete, Toggle activation         |
|           | - Authentication: Create accounts, Delete accounts, Toggle activation status |
| **User**  | - Tasks: List assigned, Change status                                        |
|           | - Statuses: Read                                                             |
|           | - Priorities: Read                                                           |
|           | - Users: Update own account                                                  |
|           | - Authentication: Log in, Log out, Update profile                            |

---

---

### Postman Collection

You can import the API collection into Postman using the following link or by downloading the JSON file:

* **Collection URL:** [https://documenter.getpostman.com/view/34255778/2sB2qUo5C5](https://documenter.getpostman.com/view/34255778/2sB2qUo5C5)

To import in Postman:

1. Open Postman.
2. Click on **Import** in the top-left corner.
3. Select **Link** and paste the URL above, or choose **File** to upload a downloaded JSON.
4. Click **Continue**, then **Import**.

*End of README*
