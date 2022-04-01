import '../assets/css/index.scss'
import {
  BrowserRouter,
  Routes,
  Route,
  Link
} from 'react-router-dom'
import Posts from './Posts'
import Users from './Users'
import Page404 from './Page404'

function App () {
  return (
    <div className="supermetricsApp">
      <BrowserRouter>
          <div>
              <ul>
                <li>
                  <Link to="/">Posts</Link>
                </li>
                <li>
                  <Link to="/users">Users</Link>
                </li>
              </ul>

            <Routes>
              <Route path="/" element={<Posts />}/>
              <Route path="/users" element={<Users />}/>
              <Route path="/*" element={<Page404 />}/>
            </Routes>
          </div>
      </BrowserRouter>
    </div>
  )
}

export default App
