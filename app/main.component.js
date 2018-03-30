const TestGridRow = React.createClass({
    render : function(){
      var base_url = window.location.href;
      var test_url = base_url + "/test/";
      var duration = (this.props.test.duration == 0) ? "Không Giới Hạn":this.props.test.duration + " Phút";
        return (
			<div className="col-md-6 col-xs-12">
				<a href={test_url + this.props.test.id}><h3 className="test-title">{this.props.test.description}</h3></a>
				<p><i>{this.props.test.created_at}</i> bởi <b>{this.props.test.creator}</b></p>
        <p>{duration}</p> 
        <p>{this.props.test.number_of_question} câu hỏi</p>
        <a href={test_url + this.props.test.id}>
				  <button type="button" className="btn btn-primary">Vào Thi</button>
        </a>
			</div>
        );
    }
});

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
    console.log(localStorage.token);
    console.log(u + '/api/quiz/tests');
    axios.get(u + '/api/quiz/tests',
    { 
      headers: {
      'Content-Type': 'application/json',
      'Authorization' : "Bearer " + localStorage.token,
      'X-API-KEY' : 'ABC'
      }
      
    }
  ).then((tests) => {
    console.log(tests.data);
        this.setState({tests: tests.data});
      });
    },
    render: function () {
        var rows = [];
        this.state.tests.map(function(test){
            rows.push(<TestGridRow key={test.id} test={test}/>);
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