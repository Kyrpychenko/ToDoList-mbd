import { TodoItem, TodoList, User } from '@/types';
import { computed, ref } from 'vue';
export const currentUser = ref<User | null>(null);
export const allLists = ref<TodoList[]>([]);
export const filterOptions = ref<'unfinished' | 'finished' | 'createdBy' | null>(null);
export const sortOptions = ref<'deadlineUp' | 'deadlineDown' | null>(null);
export const searchValue = ref('');

export function toggleFilter(option: typeof filterOptions.value) {
    if (filterOptions.value === option) filterOptions.value = null;
    else filterOptions.value = option;
}
export function toggleSort(option: typeof sortOptions.value) {
    if (sortOptions.value === option) sortOptions.value = null;
    else sortOptions.value = option;
}
export const displayedLists = computed(() => {
    return allLists.value
        .map(e => ({
            ...e,
            todo_items: e.todo_items.filter(
                t =>
                    filterOptions.value === 'finished' || filterOptions.value === 'unfinished' // besser schreiben
                        ? t.state === filterOptions.value
                        : filterOptions.value === 'createdBy'
                        ? t.user_id === currentUser.value?.id
                        : t // ???
            ),
        }))
        .map(e => ({
            ...e,
            todo_items: e.todo_items.filter(
                t => t.title.toLowerCase().includes(searchValue.value) || t.description.toLowerCase().includes(searchValue.value)
            ),
        }))
        .filter(l => l.todo_items.length !== 0)
        .map(e => ({
            ...e,
            todo_items: e.todo_items.sort((a, b) => sortFunction(a, b)),
        }));
});

export const displayedTodos = computed(() =>
    allLists.value
        .flatMap(e =>
            e.todo_items
                .filter(t =>
                    filterOptions.value === 'finished' || filterOptions.value === 'unfinished' // besser schreiben
                        ? t.state === filterOptions.value
                        : filterOptions.value === 'createdBy'
                        ? t.user_id === currentUser.value?.id
                        : t
                )
                .filter(t => t.title.toLowerCase().includes(searchValue.value) || t.description.toLowerCase().includes(searchValue.value))
        )
        .sort((a, b) => sortFunction(a, b))
);

function sortFunction(a: TodoItem, b: TodoItem) {
    return sortOptions.value === 'deadlineDown'
        ? a.deadline < b.deadline
            ? 1
            : -1
        : sortOptions.value === 'deadlineUp'
        ? a.deadline > b.deadline
            ? 1
            : -1
        : b.priority - a.priority;
}
