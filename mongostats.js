const serverStatus = require('mongodb-serverstatus');
 
var config = {
    dbPath: '/var/lib/mongodb',
    dbOptions: {
        user: '',
        pass: '',
        server: {
            ssl: false,
            sslValidate: false
        },
    }
};
 
serverStatus.init(config);
serverStatus.memory((data) => {
    console.log(data);
});