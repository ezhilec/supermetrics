import {
  GET_POSTS_ERROR,
  GET_POSTS_REQUEST,
  GET_POSTS_SUCCESS,
  SET_PAGE
} from '../actions/PostsActions'
import PostDTO from '../DTOs/PostDTO'

const initialState = {
  list: [],
  isLoading: false,
  error: null,
  page: 1,
  total: 0,
  perPage: 20,
}

const postReducer = (state = initialState, action) => {
  switch (action.type) {
    case GET_POSTS_REQUEST:
      return { ...state, error: null, isLoading: true }

    case GET_POSTS_SUCCESS:
      return {
        ...state,
        list: action.payload.list.map(item => new PostDTO({
          id: item['id'],
          fromName: item['from_name'],
          fromId: item['from_id'],
          message: item['message'],
          type: item['type'],
          createdAt: item['created_at']
        })),
        total: action.payload.total,
        isLoading: false
      }

    case GET_POSTS_ERROR:
      return { ...state, error: action.payload, isLoading: false }

    case SET_PAGE:
      return { ...state, page: action.payload }

    default:
      return state
  }
}

export default postReducer