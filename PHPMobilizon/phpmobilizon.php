<?php
namespace PHPMobilizon;

class PHPMobilizon{
    protected $Url = '';
    protected $Email = '';
    protected $Password = '';
    protected $AccessToken = '';
    protected $RefreshToken = '';
    protected $UserID;
    protected $UserRole;
    protected $Debug =false;

    /**
     * PHPMobilizon constructor.
     * @param string $Url
     * @param string $Email
     * @param string $Password
     */
    public function __construct(string $Url = '', string $Email = '', string $Password = '')
    {
        $this->Url = $Url;
        $this->Email = $Email;
        $this->Password = $Password;
    }
    /**
     * @return bool
     */
    public function isDebug(): bool{
        return $this->Debug;
    }

    /**
     * @param bool $Debug
     */
    public function setDebug(bool $Debug): void{
        $this->Debug = $Debug;
    }

    /**
     * @return string
     */
    public function getUrl(): string    {
        return $this->Url;
    }

    /**
     * @param string $Url
     */
    public function setUrl(string $Url)    {
        $this->Url = $Url;
    }


    /**
     * @return string
     */
    public function getEmail()    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail(string $Email)    {
        $this->Email = $Email;
    }

    /**
     * @return string
     */
    public function getPassword() : string    {
        return $this->Password;
    }

    /**
     * @param string $Password
     */
    public function setPassword(string $Password)    {
        $this->Password = $Password;
    }

    /**
     * @return string
     */
    public function getAccessToken() : string {
        return $this->AccessToken;
    }

    /**
     * @param string $AccessToken
     */
    public function setAccessToken(string $AccessToken) {
        $this->AccessToken = $AccessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken() : string {
        return $this->RefreshToken;
    }

    /**
     * @param string $RefreshToken
     */
    public function setRefreshToken(string $RefreshToken) {
        $this->RefreshToken = $RefreshToken;
    }

    /**
     * @return mixed
     */
    public function getUserID(){
        return $this->UserID;
    }

    /**
     * @param mixed $UserID
     */
    public function setUserID($UserID){
        $this->UserID = $UserID;
    }

    /**
     * @return mixed
     */
    public function getUserRole(){
        return $this->UserRole;
    }

    /**
     * @param mixed $UserRole
     */
    public function setUserRole($UserRole){
        $this->UserRole = $UserRole;
    }
    public function Login(string $Email = '', string $Password = '') : bool{
        $this->Email = ($Email != '') ? $Email : $this->Email;
        $this->Password = ($Password != '') ? $Password : $this->Password;
        if ($this->Password != '' && $this->Email != '') {
            try {
                return $this->ExecuteLogin();
            } catch (\Exception $e) {
                $this->log('PHPMobilizon::Login :'.$e->getMessage());
            }
        }
        return false;
    }
    public function Refresh() : bool {
        if ($this->RefreshToken != '' && $this->AccessToken != '') {
            try {
            return $this->ExecuteRefresh();
            } catch (\Exception $e) {
                $this->log('PHPMobilizon::Refresh :'.$e->getMessage());
            }
        }
        return false;
    }
    public function CreateEvent(string $organizerActorId,string $title, string $description, string $beginsOn, string $endsOn ='', string $status ='', string $visibility = '') {
        if ($this->AccessToken != '') {
            try {
                return $this->ExecuteCreateEvent($organizerActorId,$title,$description, $beginsOn, $endsOn, $status , $visibility);
            } catch (\Exception $e) {
                $this->log('PHPMobilizon::CreateEvent :'.$e->getMessage());
            }
        }
        return false;
    }

    protected function ExecuteCreateEvent(string $organizerActorId,string $title, string $description, string $beginsOn, string $endsOn ='', string $status ='', string $visibility = ''){
        $querystring="mutation createEvent(\$organizerActorId: ID!, \$attributedToId: ID, \$title: String!, \$description: String!, \$beginsOn: DateTime!, \$endsOn: DateTime, \$status: EventStatus, \$visibility: EventVisibility, \$joinOptions: EventJoinOptions, \$draft: Boolean, \$tags: [String], \$picture: MediaInput, \$onlineAddress: String, \$phoneAddress: String, \$category: String, \$physicalAddress: AddressInput, \$options: EventOptionsInput, \$contacts: [Contact], \$metadata: EventMetadataInput) {\n  createEvent(\n    organizerActorId: \$organizerActorId\n    attributedToId: \$attributedToId\n    title: \$title\n    description: \$description\n    beginsOn: \$beginsOn\n    endsOn: \$endsOn\n    status: \$status\n    visibility: \$visibility\n    joinOptions: \$joinOptions\n    draft: \$draft\n    tags: \$tags\n    picture: \$picture\n    onlineAddress: \$onlineAddress\n    phoneAddress: \$phoneAddress\n    category: \$category\n    physicalAddress: \$physicalAddress\n    options: \$options\n    contacts: \$contacts\n    metadata: \$metadata\n  ) {\n    ...FullEvent\n    __typename\n  }\n}\n\nfragment FullEvent on Event {\n  id\n  uuid\n  url\n  local\n  title\n  description\n  beginsOn\n  endsOn\n  status\n  visibility\n  joinOptions\n  draft\n  language\n  picture {\n    id\n    url\n    name\n    metadata {\n      width\n      height\n      blurhash\n      __typename\n    }\n    __typename\n  }\n  publishAt\n  onlineAddress\n  phoneAddress\n  physicalAddress {\n    ...AdressFragment\n    __typename\n  }\n  organizerActor {\n    ...ActorFragment\n    __typename\n  }\n  contacts {\n    ...ActorFragment\n    __typename\n  }\n  attributedTo {\n    ...ActorFragment\n    __typename\n  }\n  participantStats {\n    going\n    notApproved\n    participant\n    __typename\n  }\n  tags {\n    ...TagFragment\n    __typename\n  }\n  relatedEvents {\n    id\n    uuid\n    title\n    beginsOn\n    status\n    language\n    picture {\n      id\n      url\n      name\n      metadata {\n        width\n        height\n        blurhash\n        __typename\n      }\n      __typename\n    }\n    physicalAddress {\n      ...AdressFragment\n      __typename\n    }\n    organizerActor {\n      ...ActorFragment\n      __typename\n    }\n    attributedTo {\n      ...ActorFragment\n      __typename\n    }\n    options {\n      ...EventOptions\n      __typename\n    }\n    tags {\n      ...TagFragment\n      __typename\n    }\n    __typename\n  }\n  options {\n    ...EventOptions\n    __typename\n  }\n  metadata {\n    key\n    title\n    value\n    type\n    __typename\n  }\n  __typename\n}\n\nfragment AdressFragment on Address {\n  id\n  description\n  geom\n  street\n  locality\n  postalCode\n  region\n  country\n  type\n  url\n  originId\n  timezone\n  __typename\n}\n\nfragment TagFragment on Tag {\n  id\n  slug\n  title\n  __typename\n}\n\nfragment EventOptions on EventOptions {\n  maximumAttendeeCapacity\n  remainingAttendeeCapacity\n  showRemainingAttendeeCapacity\n  anonymousParticipation\n  showStartTime\n  showEndTime\n  timezone\n  offers {\n    price\n    priceCurrency\n    url\n    __typename\n  }\n  participationConditions {\n    title\n    content\n    url\n    __typename\n  }\n  attendees\n  program\n  commentModeration\n  showParticipationPrice\n  hideOrganizerWhenGroupEvent\n  isOnline\n  __typename\n}\n\nfragment ActorFragment on Actor {\n  id\n  avatar {\n    id\n    url\n    __typename\n  }\n  type\n  preferredUsername\n  name\n  domain\n  summary\n  url\n  __typename\n}";
        $beginsOn =date(DATE_ISO8601, strtotime($beginsOn));
        $endsOn =date(DATE_ISO8601, strtotime($endsOn));
        $variables = <<<JSON
      {
       "organizerActorId": "$organizerActorId",
       "title": "$title",
       "description": "$description",       
       "beginsOn": "$beginsOn",
       "endsOn": "$endsOn",
       "status": "$status",
       "visibility": "$visibility"        
        }
JSON;
        $ret = $this->executeapicall($querystring, $variables,'') ;
        return $ret;
    }
    protected function ExecuteLogin() {
        $querystring = <<<JSON
          mutation Login(\$email: String!, \$password: String!) {
              login(email: \$email, password: \$password) {
              accessToken
              refreshToken
              user {
                id
                email
                role
              }
            }
          }
JSON;
    $variables = <<<JSON
      {"email":"$this->Email",
      "password":"$this->Password"
      }
JSON;
       $ret = $this->executeapicall($querystring, $variables);
       if ($ret) {
           $this->AccessToken = $ret->data->login->accessToken;
           $this->RefreshToken = $ret->data->login->refreshToken;
           $this->UserID = $ret->data->login->user->id;
           $this->UserRole = $ret->data->login->user->role;
           return true;
       }
       return false;
    }
    protected function ExecuteRefresh() :bool{
       $querystring = <<<JSON
      mutation RefreshToken(\$refreshToken: String!) {
        refreshToken(refreshToken: \$refreshToken) {
          accessToken
          refreshToken
        }
      }
JSON;
        $variables = <<<JSON
      {"accessToken":"$this->AccessToken",
      "refreshToken":"$this->RefreshToken"
        }
JSON;
        $ret = $this->executeapicall($querystring, $variables);
        if ($ret) {
            $this->AccessToken = $ret->data->refreshToken->accessToken;
            $this->RefreshToken = $ret->data->refreshToken->refreshToken;
            return true;
        }
       return false;
    }

    public function Query(string $querystring = '') {
        $querystring = ($querystring == '')
            ?'events {elements {id,url,title,description,beginsOn,endsOn,status,picture {url},physicalAddress {id,description,locality}}total}'
            :$querystring
        ;
        $query ='query{'.$querystring.'}';
        try {
            $ret = $this->executeapicall($query);
        } catch (\Exception $e) {
            error_log('PHPMobilizon::Query :'.$e->getMessage());
            return false;
        }
        return $ret;
    }

    protected function executeapicall(string $query, string $variables = '', $operationName = '') {

        $data = array ('query' => $query, 'variables' => $variables, 'operationName' => $operationName);
        $data = http_build_query($data);

        $options = array(
            'http' => array(
                'header'  => sprintf("Authorization: Bearer %s",$this->AccessToken),
                'method'  => 'POST',
                'content' => $data
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($this->Url, false, $context);

        if ($result === FALSE) {
            throw new \Exception('PHPMobilizon executeapicall failed query:'.$query.$variables);
            return false;
        }
        return json_decode($result);
    }

    protected function log(string $message) {
        error_log($message);
        if ($this->Debug) {
            echo $message;
        }
    }

}
