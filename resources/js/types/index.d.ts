export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    role: 'admin' | 'user' | 'readOnly';
    todoLists: TodoList[];
}
export type TodoItem = {
    id: number;
    title: string;
    description: string;
    state: 'in work' | 'completed' | '';
    listId: number;
    priority: 1 | 2 | 3;
    assignedTo: User[];
};
export type TodoList = {
    id: number;
    todos: TodoItem[];
    name: string;
};

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
