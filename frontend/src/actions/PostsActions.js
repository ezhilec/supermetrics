import { getPostsRequest } from '../api'

const PREFIX = 'SUPERMETRICS_POSTS__'

export const GET_POSTS_REQUEST = PREFIX + 'GET_POSTS_REQUEST'
export const GET_POSTS_SUCCESS = PREFIX + 'GET_POSTS_SUCCESS'
export const GET_POSTS_ERROR = PREFIX + 'GET_POSTS_ERROR'

export const getPosts = (page) => async dispatch => {
  dispatch({
    type: GET_POSTS_REQUEST,
  })

  try {
    const response = await getPostsRequest(page)
    dispatch({
      type: GET_POSTS_SUCCESS,
      payload: response.data.data,
    })
  } catch (e) {
    dispatch({
      type: GET_POSTS_ERROR,
      payload: "Can't get posts list",
    })
  }
}