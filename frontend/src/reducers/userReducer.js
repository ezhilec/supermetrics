import {
  GET_USER_ERROR,
  GET_USER_REQUEST,
  GET_USER_SUCCESS,
  GET_USERS_ERROR,
  GET_USERS_REQUEST,
  GET_USERS_SUCCESS,
  SET_PAGE
} from '../actions/UsersActions'
import UserDTO from '../DTOs/UserDTO'
import UserStatisticsDTO from '../DTOs/UserStatisticsDTO'
import PostDTO from '../DTOs/PostDTO'

const initialState = {
  list: [],
  isLoading: false,
  page: 1,
  total: 0,
  perPage: 5,
}

const userReducer = (state = initialState, action) => {
  switch (action.type) {
    case GET_USERS_REQUEST:
      return { ...state, error: null, isLoading: true }

    case GET_USERS_SUCCESS:
      return {
        ...state,
        list: action.payload.list.map(item => new UserDTO({
          id: item['id'],
          name: item['name'],
        })),
        total: action.payload.total,
        isLoading: false
      }

    case GET_USERS_ERROR:
      return { ...state, error: action.payload, isLoading: false }

    case GET_USER_REQUEST:
      return { ...state, error: null, isLoading: true }

    case GET_USER_SUCCESS:
      return {
        ...state,
        current: new UserStatisticsDTO({
          userPostsCount: action.payload['user_posts_count'],
          avgMessageLength: action.payload['avg_message_length'],
          postsByMonth: action.payload['posts_by_month'],
          maxMessagePost: new PostDTO({
            id: action.payload['max_message_post']['id'],
            fromName: action.payload['max_message_post']['from_name'],
            fromId: action.payload['max_message_post']['from_id'],
            message: action.payload['max_message_post']['message'],
            type: action.payload['max_message_post']['type'],
            createdAt: action.payload['max_message_post']['created_at']
          }),
          user: new UserDTO({
            id: action.payload['user']['id'],
            name: action.payload['user']['name'],
          })
        }),
        isLoading: false
      }

    case GET_USER_ERROR:
      return { ...state, error: action.payload, isLoading: false }

    case SET_PAGE:
      return { ...state, page: action.payload }

    default:
      return state
  }
}

export default userReducer