/**
 * WordPress Dependencies
 */
const { __ } = wp.i18n;

const {
	Component
} = wp.element;

const {
   Button,
   PanelBody
} = wp.components;

const { withSelect } = wp.data;

export class ClaimTask extends Component {

	constructor() {
      super(...arguments);

      this.state = {
         isBusy: false,
         success: [],
         responseErrors: []
      }

      this.handleClaim = this.handleClaim.bind(this);
   }

   /**
    * handle form submit for workflow abort
    */
   handleClaim() {
      event.preventDefault();
      this.setState({
         isBusy: true
      });

      let postId = this.props.postId

		let form_data = {
         post_id : postId,
         history_id : this.props.actionHistoryId
      };

      wp.apiFetch({ path: '/oasis-workflow/v1/workflows/claim/', method: 'POST', data: form_data }).then(
			(claimResponse) => {
            let errors = [];
            if( claimResponse.isError === "true" ) {
               errors.push(claimResponse.errorMessage);
               this.setState({
                  responseErrors: errors
              });
              return;
            } 
            
            if( claimResponse.isError === "false" ) {
               let new_history_id = claimResponse.new_history_id;
               let ow_admin_url = claimResponse.url;
               window.location.href = ow_admin_url + 'post.php?post=' + postId +'&action=edit&oasiswf=' + new_history_id;
            }                       
			},
			(err) => {
				console.log(err);			
				return err;
         }
      );
   }

	componentDidMount() {
		// reset to default state
		this.setState({
         isBusy: false
      });
   }   

   render() {
      const { responseErrors } = this.state;
      return (
         <div>
            { responseErrors.length !== 0 ?
               (  <div id="owf-error-message" className="notice notice-error is-dismissible">
                     {responseErrors.map(error =>
                        <p key={error}>{error}</p>
                     )}
               </div> ) : ""
            }
            { !this.props.isHidden ? 
               ( 
                  <PanelBody>
                     <Button
                        focus = "true"
                        isPrimary
                        isLarge
                        onClick = { this.handleClaim }
                     >
                        { __('Claim', 'oasisworkflow' ) }         
                     </Button>
                  </PanelBody>   
               ) : ""
            }
         </div>        
      )
   }
}

export default withSelect( ( select ) => {
   const { getCurrentPostId } = select('core/editor');
   return {
      postId: getCurrentPostId()
   };
} )( ClaimTask );