pipeline {
    agent {
        docker {
            image 'php:8-cli'   // официальный PHP CLI образ
            args '-v $PWD:/app -w /app' // монтируем проект внутрь контейнера
        }
    }

    stages {
        stage('Checkout') {
            steps {
                git url: 'https://github.com/andreydjurinschi/php-IndividualWork-mysql.git', branch: 'main'
            }
        }

        stage('Build Docker') {
            steps {
                sh './tests/docker_test.sh'
            }
        }
    }

    post {
        always { echo 'Pipeline завершен.' }
        success { echo 'Все этапы прошли успешно!' }
        failure { echo 'Обнаружены ошибки в pipeline.' }
    }
}
