import { Link } from 'react-router-dom'

function Page404 () {
  return (
    <div>
      <h3>
        Page not found. <Link to="/">Back to index page</Link>
      </h3>
    </div>
  )
}

export default Page404
