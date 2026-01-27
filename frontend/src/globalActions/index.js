import EventBus, { ACTIONS } from '../EventBus/index';

export const showSnackbar = (message, color) => {
  EventBus.$emit(ACTIONS.SNACKBAR, { message, color });
};