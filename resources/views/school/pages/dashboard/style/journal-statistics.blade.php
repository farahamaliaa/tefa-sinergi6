<style>
.statistik-container {
    display: flex;
    align-items: center;
    position: relative;
}

.line {
    flex-grow: 1;
    height: 2px;
    background-color: transparent;
    margin-top: 7px;
    margin-left: 10px;
    position: relative;
}

.line::before,
.line::after,
.line .small-line,
.line .smaller-line {
    content: '';
    position: absolute;
    top: 0;
    height: 2px;
    background-color: #CECECE;
}

.line::before {
    left: 0;
    width: 60%;
}

.line::after {
    right: 25%;
    width: 15%;
}

.line .small-line {
    right: 15%;
    width: 10%;
}

.line .smaller-line {
    right: 0;
    width: 5%;
}
</style>

<style>

.card-body-with-line::before {
    content: '';
    position: absolute;
    left: 10px;
    height: 85px;
    top: 20px;
    bottom: 0;
    width: 4px;
    background-color: #0F95CE;
    border-radius: 2px;
}

.card-body-with-line2::before {
    content: '';
    position: absolute;
    left: 10px;
    height: 85px;
    top: 20px;
    bottom: 0;
    width: 4px;
    background-color: #23B89B;
    border-radius: 2px;
}

.card-body-with-line3::before {
    content: '';
    position: absolute;
    left: 10px;
    height: 85px;
    top: 20px;
    bottom: 0;
    width: 4px;
    background-color: #DD2224;
    border-radius: 2px;
}

/* opsional: biar keliatan lebih rapi */
.card-body-with-line,
.card-body-with-line2,
.card-body-with-line3 {
    border-radius: 1rem;
    background-color: white;
    transition: all 0.3s ease;
}

.card-body-with-line:hover,
.card-body-with-line2:hover,
.card-body-with-line3:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
</style>
