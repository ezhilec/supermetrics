import { GET_POSTS_ERROR, GET_POSTS_REQUEST, GET_POSTS_SUCCESS } from '../actions/PostsActions'

const initialState = {
  list: [],
  isLoading: false,
  page: 1
}

const postReducer = (state = initialState, action) => {
  switch (action.type) {
    case GET_POSTS_REQUEST:
      return { ...state, error: null, isLoading: true }

    case GET_POSTS_SUCCESS:
      return { ...state, list: action.payload, isLoading: false }

    case GET_POSTS_ERROR:
      return { ...state, error: action.payload, isLoading: false }

    default:
      return state
  }
}

export default postReducer