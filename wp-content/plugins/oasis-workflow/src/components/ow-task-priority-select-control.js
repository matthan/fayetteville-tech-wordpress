/**
 * WordPress Dependencies
 */
const { Component } = wp.element;
const { __ } = wp.i18n;
const { SelectControl } = wp.components;
const { pick } = lodash;
const { withSelect } = wp.data;
const { compose } = wp.compose;

export class TaskPriorities extends Component {
	constructor() {
      super(...arguments);

		this.state = {
         priorityLabel: __( 'Priority', 'oasisworkflow' ),
			priorities: [],
			displayPriority : ''
      }
   }

   componentDidMount() {
		let customWorkflowTerminology = this.props.owSettings.terminology_settings.oasiswf_custom_workflow_terminology;
		let workflowSettings = this.props.owSettings.workflow_settings;

      if( customWorkflowTerminology ) {
			let priorityLabel = customWorkflowTerminology.taskPriorityText;
			this.setState({
            priorityLabel
         });
		}

		if( workflowSettings ) {
         let displayPriority = workflowSettings.oasiswf_priority_setting;
         this.setState({
            displayPriority
         });
      }

		// fetch priority List
		wp.apiFetch({ path: '/oasis-workflow/v1/priorities', method: 'GET' }).then(
			(data) => {	
				let priorityData = data.map((priority) => pick(priority, ['key', 'value']));
				let priorities = [];
				priorityData.map(priority => {
					priorities.push({ label: priority.value, value: priority.key})
				},
				)
				this.setState({
					priorities: priorities
				});
				return data;
			},
			(err) => {
				console.log(err);			
				return err;
			}
		);	      
   }

   render() {
		const { priorityLabel, displayPriority } = this.state;
      return (
			<div>
			{ displayPriority === "enable_priority" ? (
         <SelectControl
            label={ priorityLabel + ':' }
            value={this.props.value}
            options={this.state.priorities}
            onChange={this.props.onChange}
			/> ) : ""
			} 
			</div>    
      )
   }
}

export default compose([
	withSelect((select) => {
      const { getOWSettings } = select ('plugin/oasis-workflow');
		return {
         owSettings: getOWSettings()
		};
	})
])(TaskPriorities);