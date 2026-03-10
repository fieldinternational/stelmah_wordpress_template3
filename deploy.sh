#!/bin/bash

# 定義ファイル名
ENV_FILE=".env"
ENV_EXAMPLE_FILE=".env_example"

# .envファイルが存在しない場合、.env_exampleをコピー
if [ ! -f "$ENV_FILE" ]; then
  if [ -f "$ENV_EXAMPLE_FILE" ]; then
    echo ".env file does not exist. Copying from .env_example..."
    cp "$ENV_EXAMPLE_FILE" "$ENV_FILE"
  else
    echo "Error: .env_example file does not exist. Please create it first."
    exit 1
  fi
fi

# DOMAIN変数を確認または更新
if grep -qE "^DOMAIN=" "$ENV_FILE"; then
  CURRENT_DOMAIN=$(grep -E "^DOMAIN=" "$ENV_FILE" | cut -d'=' -f2)
else
  CURRENT_DOMAIN=""
fi

if [ -z "$CURRENT_DOMAIN" ]; then
  echo "DOMAIN is not set or empty in .env file."
  read -p "Please enter the domain: " INPUT_DOMAIN

  if [ -z "$INPUT_DOMAIN" ]; then
    echo "Error: Domain cannot be empty."
    exit 1
  fi

  # DOMAINを更新
  # macOSとLinuxの`sed`の互換性を確保
  if [[ "$OSTYPE" == "darwin"* ]]; then
    sed -i '' "s/^DOMAIN=.*/DOMAIN=${INPUT_DOMAIN}/" "$ENV_FILE"
  else
    sed -i "s/^DOMAIN=.*/DOMAIN=${INPUT_DOMAIN}/" "$ENV_FILE"
  fi

  echo "DOMAIN has been updated to '${INPUT_DOMAIN}' in .env file."
else
  echo "DOMAIN is already set to '${CURRENT_DOMAIN}' in .env file."
fi

# COMPOSE_FILE変数を確認または更新
if grep -qE "^COMPOSE_FILE=" "$ENV_FILE"; then
  if [[ "$OSTYPE" == "darwin"* ]]; then
    sed -i '' "s/^COMPOSE_FILE=.*/COMPOSE_FILE=docker-compose.production.yml/" "$ENV_FILE"
  else
    sed -i "s/^COMPOSE_FILE=.*/COMPOSE_FILE=docker-compose.production.yml/" "$ENV_FILE"
  fi
else
  echo "COMPOSE_FILE=docker-compose.production.yml" >> "$ENV_FILE"
fi

echo "COMPOSE_FILE has been updated to 'docker-compose.production.yml' in .env file."

# Nginxのログを作成する
echo "Create Nginx log files"
# 対象のディレクトリ
LOG_DIR="docker/nginx/log"

# ディレクトリが存在するか確認
if [ ! -d "$LOG_DIR" ]; then
  echo "Directory '$LOG_DIR' does not exist. Creating it..."

  # ディレクトリ作成
  mkdir -p "$LOG_DIR"

  echo "Directory '$LOG_DIR' has been created."
else
  echo "Directory '$LOG_DIR' already exists."
fi
touch docker/nginx/log/access.log
touch docker/nginx/log/error.log


# Wordpressのpluginsのディレクトリ作成
mkdir apps/wp-content/plugins

# docker-compose up -d実行
echo "Run docker-compose up -d"
docker-compose up -d

# wp-config.phpの作成
cp apps/wp-config-sample.php apps/wp-config.php

# wordpressコンテナ内の権限変更
docker-compose exec app chown -R www-data:www-data ./

# テーマの権限をec2-userに変更
sudo chown ec2-user:ec2-user -R apps/wp-content/themes/stelmah
