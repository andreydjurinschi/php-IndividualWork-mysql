pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git url: 'https://github.com/andreydjurinschi/php-IndividualWork-mysql.git', branch: 'main'
            }
        }

        stage('Test PHP') {
            steps {
                sh 'php -v'  
            }
        }
    }

    post {
        always { echo 'Pipeline завершен.' }
        success { echo 'Все этапы прошли успешно!' }
        failure { echo 'Обнаружены ошибки в pipeline.' }
    }
}
