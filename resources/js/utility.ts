export type Priority = (typeof priorityArray)[number];

export const priorityArray = ['Niedrig', 'Mittel', 'Hoch'] as const;

export function getPriorityNumber(priority: Priority) {
    return (priorityArray.indexOf(priority) + 1) as 1 | 2 | 3;
}

export function getPriorityString(priority: 1 | 2 | 3) {
    return priorityArray[priority - 1];
}
