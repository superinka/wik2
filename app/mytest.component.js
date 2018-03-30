const Table = React.createClass({
    render : function(){
        return (
            <BootstrapTable data={ test }>
              <TableHeaderColumn dataField='id' isKey>Product ID</TableHeaderColumn>
              <TableHeaderColumn dataField='name'>Product Name</TableHeaderColumn>
              <TableHeaderColumn dataField='price'>Product Price</TableHeaderColumn>
            </BootstrapTable>
        );
    }
});
function parseJwt(token) {
	var base64Url = token.split('.')[1];
	var base64 = base64Url.replace('-', '+').replace('_', '/');
	return JSON.parse(window.atob(base64));
};
var token = parseJwt(localStorage.token);

const MainApp = React.createClass({
    getInitialState: function () {
      return {
        tests: []
      }
    },
    componentDidMount: function () {
      this.loadUsersFromServer();
    },
    loadUsersFromServer: function () {
        var u = window.location.origin;
		axios.post( u + '/api/quiz/mytests', {
			user_id: token.id
		}, {
				headers: {
					'Authorization': "Bearer " + localStorage.token
				}
			})
			.then((test) => {
				console.log(test.data);
				this.setState({ tests: test.data });
			})
			.catch(function (error) {
				console.log(error);
			});
	},
    render: function () {
        var rows = [];
        this.state.tests.map(function(test){
            rows.push(<Table key={test.id} test={test}/>);
        });
       return (
		   <div>
				<div className="container">
					<div className="row">
						{rows}
					</div>
				</div>
		   </div>
	   );
    }
  });
 
ReactDOM.render(
    <MainApp />,
    document.getElementById('app')
);