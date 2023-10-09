export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    role: 'admin' | 'user' | 'readOnly'|;
    tasks: Task[];
}

type Task = {
    id: number;
    taskLogs: TaskLog[];
};

export type TaskLog = {
    id: number;
};

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
