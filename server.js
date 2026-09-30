const express = require('express');
const path = require('path');
const os = require('os');

const app = express();
const PORT = process.env.PORT || 3000;

// Explicitly serve Inventory_2_12.html on root route
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'Inventory_2_12.html'));
});

// Serve static assets
app.use(express.static(__dirname));

// Smart IP detection ignoring VirtualBox/VMware/Host-Only adapters
function getLocalIP() {
    const interfaces = os.networkInterfaces();
    let candidates = [];

    for (const name of Object.keys(interfaces)) {
        // Skip virtual interfaces
        if (/virtualbox|vbox|vmware|vethernet|host-only|loopback/i.test(name)) {
            continue;
        }

        for (const net of interfaces[name]) {
            if (net.family === 'IPv4' && !net.internal) {
                // Ignore 192.168.56.x explicitly
                if (!net.address.startsWith('192.168.56.')) {
                    candidates.push(net.address);
                }
            }
        }
    }

    return candidates.length > 0 ? candidates[0] : 'localhost';
}

app.listen(PORT, '0.0.0.0', () => {
    const localIP = getLocalIP();
    console.log('====================================================');
    console.log(`Inventory System Server is running!`);
    console.log(`- Host PC:   http://localhost:${PORT}`);
    console.log(`- Mobile/LAN: http://${localIP}:${PORT}`);
    console.log('====================================================');
});