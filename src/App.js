import Preact from 'preact';

class App extends Preact.Component {
    constructor() {
        super();
        let initialState = {
            data: [],
            groups: [],
            baseUrl: ''
        };
        this.state = window._seed || initialState;
    }

    componentDidMount() {
    }

    getFreshData() {
        fetch('/', { headers: { 'Accept': 'application/json' } })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Something went wrong ...');
                }
            })
            .then(data => this.setState({
                data: data.data,
                groups: data.groups,
                baseUrl: data.baseUrl,
                isLoading: false
            }))
            .catch(error => this.setState({ error, isLoading: false }));
    }

    render() {
        const { data, groups, baseUrl } = this.state;

        return (
            <div className="container">
                <h1>433PiRemote</h1>
                <div id="remotes" className="section">
                    {data.map(item => (
                        <div>
                            <h2>{item.name}</h2>
                            <div className="row buttons">
                                <div className="col-xs-6">
                                    <a className="btn btn-danger btn-block switch"
                                       href={`${baseUrl}/do/?id=${item.id}&action=off`}>aus</a>
                                </div>
                                <div className="col-xs-6">
                                    <a className="btn btn-success btn-block switch"
                                       href={`${baseUrl}/do/?id=${item.id}&action=on`}>an</a>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                <div id="groups" className="section hidden">
                    {groups.map(group => (
                        <div>
                            <h2>{group.name}</h2>
                            <div className="row buttons">
                                <div className="col-xs-6">
                                    <a className="btn btn-danger btn-block switch"
                                       href={`${baseUrl}/do/?group=${group.id}&action=off`}>aus</a>
                                </div>
                                <div className="col-xs-6">
                                    <a className="btn btn-success btn-block switch"
                                       href={`${baseUrl}/do/?group=${group.id}&action=on`}>an</a>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                {/*
                <div style="margin-top: 20px">
                    <nav className="navbar navbar-default navbar-collapse" role="navigation">
                        <ul className="nav navbar-nav sectionTrigger">
                            <li className="active"><a href="#remotes">Einzeln</a></li>
                            <li><a href="#groups">Gruppen</a></li>
                        </ul>
                        <ul className="nav navbar-nav navbar-right">
                            <li><a href={`${baseUrl }/admin/`}>Verwaltung</a></li>
                        </ul>
                    </nav>
                </div>
                */}
            </div>
        );
    }
}

export default App;
