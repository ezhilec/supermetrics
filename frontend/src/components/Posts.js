import React, { useEffect } from 'react'
import { useSelector, useDispatch } from 'react-redux'
import { getPosts } from '../actions/PostsActions'

function Posts () {
  const list = useSelector(state => state.posts.list)

  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(getPosts(1))
  }, [])

  return (
    <div className="posts">
      posts
      <ul>
        {list && list.map((post) =>
          <li key={post.id}>
            {post.id}
          </li>
        )}
      </ul>
    </div>
  )
}

export default Posts
