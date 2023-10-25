export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    role: 'admin' | 'user' | 'readOnly';
    todo_lists: TodoList[];
}
export type TodoItem = {
    id: number;
    title: string;
    description: string;
    state: 'Unstarted' | 'InWork' | 'Finished';
    listId: number;
    priority: 1 | 2 | 3;
    todo_item_user: User[];
    deadline: string;
};
export type TodoList = {
    id: number;
    todo_items: TodoItem[];
    name: string;
};

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
