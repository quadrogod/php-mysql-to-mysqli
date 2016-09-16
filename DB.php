class DB
{   //@todo: по хорошему добавить инстанс, который будет возвращать экземпляр, с возможностью смены конфига налету
    static $link;
    static $config = [
        'mysql_server' => 'localhost',
        'mysql_database' => 'abc',
        'mysql_user' => 'root',
        'mysql_password' => '',
        'driver' => 'mysqli', // mysql or mysqli
        'mysql_charset' => 'utf8',
    ];


    public static function connect() // сюда по хорошему добавить коннект в зависимости от драйвера
    {        
        if(empty(self::$link))
        {
            
            switch (self::$config['driver'])
            {
                case 'mysql':
                    self::$link = @mysql_connect(self::$config['mysql_server'], self::$config['mysql_user'], self::$config['mysql_password']);
                    mysql_select_db(self::$config['mysql_database'], self::$link) 
                            OR die(include(ROOT_DIR.'dummy.php'));
                    mysql_query("SET NAMES '" . self::$config['mysql_charset'] . "'");
                    mysql_query("SET CHARACTER SET '" . self::$config['mysql_charset'] . "'");                                                
                    break;
                
                case 'mysqli':
                default:
                    self::$link = @mysqli_connect(self::$config['mysql_server'], self::$config['mysql_user'], self::$config['mysql_password'], self::$config['mysql_database']) 
                        OR die(include(ROOT_DIR.'dummy.php')); 
                    mysqli_set_charset(self::$link, self::$config['mysql_charset']);
                    break;
            }                                                
        }
        
        return self::$link;
    }
    
    public static function setConfig(array $config)
    {
        self::$config = array_merge(self::$config, $config);
    }
    
    public static function mysql_query($query){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_query($query, DB::connect());
                break;
            case 'mysqli':
            default:
                return mysqli_query(DB::connect(), $query); 
                break;
        }        
    }
    
    public static function mysql_error(){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_error(DB::connect());
                break;
            case 'mysqli':
            default:
                return mysqli_error(DB::connect());            
                break;
        }        
    }        
    
    public static function mysql_real_escape_string($string){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_real_escape_string($string, DB::connect());
                break;
            case 'mysqli':
            default:
                return mysqli_real_escape_string(DB::connect(), $string);            
                break;
        }
    }
    
    public static function mysql_affected_rows(){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_affected_rows(DB::connect());
                break;
            case 'mysqli':
            default:
                return mysqli_affected_rows(DB::connect());            
                break;
        }
    }
    
    public static function mysql_num_rows($result){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_num_rows($result);
                break;
            case 'mysqli':
            default:
                return mysqli_num_rows($result);            
                break;
        }
    }
    
    public static function mysql_fetch_row($result){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_fetch_row($result);
                break;
            case 'mysqli':
            default:
                return mysqli_fetch_row($result);            
                break;
        }
    }
    
    public static function mysql_fetch_assoc($result){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_fetch_assoc($result);
                break;
            case 'mysqli':
            default:
                return mysqli_fetch_assoc($result);            
                break;
        }
    }
    
    public static function mysql_fetch_array($result){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_fetch_array($result);
                break;
            case 'mysqli':
            default:
                return mysqli_fetch_array($result);            
                break;
        }
    }
    
    public static function mysql_insert_id(){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_insert_id(DB::connect());
                break;
            case 'mysqli':
            default:
                return mysqli_insert_id(DB::connect());            
                break;
        }
    } 
    
    public static function mysql_close(){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_close(DB::connect());
                break;
            case 'mysqli':
            default:
                return mysqli_close(DB::connect());            
                break;
        }
    } 
    
    public static function mysql_get_server_info(){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_get_server_info(DB::connect());
                break;
            case 'mysqli':
            default:
                return mysqli_get_server_info(DB::connect());            
                break;
        }
    }  
    
    public static function mysql_result($result, $row, $field = 0){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_result($result, $row, $field);
                break;
            case 'mysqli':
            default:
                $numrows = mysqli_num_rows($result); 
                if ($numrows && $row <= ($numrows-1) && $row >=0)
                {
                    mysqli_data_seek($result, $row);
                    $resrow = (is_numeric($field)) ? mysqli_fetch_row($result) : mysqli_fetch_assoc($result);
                    if (isset($resrow[$field]))
                    {
                        return $resrow[$field];
                    }
                }
                return false;                
                break;
        }
    }
    
    public static function mysql_free_result(&$result){
        switch (self::$config['driver'])
        {
            case 'mysql':
                return mysql_free_result($result);
                break;
            case 'mysqli':
            default:
                return mysqli_free_result($result);            
                break;
        }
    }
        
}
